<?php

declare(strict_types=1);

namespace Nova\Departments\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Nova\Departments\Actions\DuplicatePosition;
use Nova\Departments\DataTransferObjects\PositionData;
use Nova\Departments\Events\PositionDuplicated;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Departments\Responses\DuplicatePositionResponse;
use Nova\Foundation\Controllers\Controller;

class DuplicatePositionController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function confirm(Request $request)
    {
        $position = Position::findOrFail($request->id);

        return DuplicatePositionResponse::sendWith([
            'departments' => Department::get(),
            'position' => $position,
        ]);
    }

    public function duplicate(Request $request, Position $original)
    {
        $this->authorize('duplicate', $original);

        $position = DuplicatePosition::run(
            $original,
            PositionData::fromRequest($request)
        );

        PositionDuplicated::dispatch($position, $original);

        $redirect = redirect()
            ->withToast("{$position->name} has been created", "All of the data from {$original->name} has been duplicated into your new position.");

        if (Gate::allows('update', $position)) {
            return $redirect->route('positions.edit', $position);
        }

        return $redirect->route('positions.index', $position->department_id);
    }
}
