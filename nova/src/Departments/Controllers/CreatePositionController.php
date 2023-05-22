<?php

declare(strict_types=1);

namespace Nova\Departments\Controllers;

use Illuminate\Http\Request;
use Nova\Departments\Actions\CreatePosition;
use Nova\Departments\Data\PositionData;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Departments\Requests\CreatePositionRequest;
use Nova\Departments\Responses\CreatePositionResponse;
use Nova\Foundation\Controllers\Controller;

class CreatePositionController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        $this->authorize('create', Position::class);

        return CreatePositionResponse::sendWith([
            'departments' => Department::ordered()->get(),
            'selectedDepartment' => Department::find($request->department),
        ]);
    }

    public function store(CreatePositionRequest $request)
    {
        $this->authorize('create', Position::class);

        $position = CreatePosition::run(PositionData::from($request));

        return redirect()
            ->route('positions.index', $position->department)
            ->withToast("{$position->name} was created");
    }
}
