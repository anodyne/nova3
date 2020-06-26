<?php

namespace Nova\Departments\Http\Controllers;

use Illuminate\Http\Request;
use Nova\Departments\Models\Position;
use Nova\Departments\Models\Department;
use Nova\Departments\Actions\CreatePosition;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Departments\DataTransferObjects\PositionData;
use Nova\Departments\Http\Requests\CreatePositionRequest;
use Nova\Departments\Http\Responses\CreatePositionResponse;

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

        return app(CreatePositionResponse::class)->with([
            'departments' => Department::orderBySort()->get(),
            'selectedDepartment' => Department::find($request->department),
        ]);
    }

    public function store(CreatePositionRequest $request, CreatePosition $action)
    {
        $this->authorize('create', Position::class);

        $position = $action->execute(PositionData::fromRequest($request));

        return redirect()
            ->route('positions.index', $position->department)
            ->withToast("{$position->name} was created");
    }
}
