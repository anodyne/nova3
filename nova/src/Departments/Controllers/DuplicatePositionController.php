<?php

namespace Nova\Departments\Controllers;

use Illuminate\Http\Request;
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

        return app(DuplicatePositionResponse::class)->with([
            'departments' => Department::get(),
            'positions' => $position,
        ]);
    }

    public function duplicate(
        Request $request,
        DuplicatePosition $action,
        Position $original
    ) {
        $this->authorize('duplicate', $original);

        $position = $action->execute(
            $original,
            PositionData::fromRequest($request)
        );

        PositionDuplicated::dispatch($position, $original);

        return redirect()
            ->route('positions.edit', $position)
            ->withToast("{$position->name} has been created", "All of the data from {$original->name} has been duplicated into your new position.");
    }
}
