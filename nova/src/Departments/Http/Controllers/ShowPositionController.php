<?php

namespace Nova\Departments\Http\Controllers;

use Illuminate\Http\Request;
use Nova\Departments\Models\Position;
use Nova\Departments\Models\Department;
use Nova\Departments\Filters\PositionFilters;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Departments\Http\Responses\ShowPositionResponse;
use Nova\Departments\Http\Responses\ShowAllPositionsResponse;

class ShowPositionController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function all(Request $request, PositionFilters $filters, $departmentId)
    {
        $this->authorize('viewAny', Department::class);

        $positions = Position::whereDepartment($departmentId)
            ->filter($filters)
            ->orderBySort();

        $positions = ($request->has('reorder'))
            ? $positions->get()
            : $positions->paginate();

        return app(ShowAllPositionsResponse::class)->with([
            'department' => Department::find($departmentId),
            'isReordering' => $request->has('reorder'),
            'positionCount' => ($request->has('reorder')) ? $positions->count() : $positions->total(),
            'positions' => $positions,
            'search' => $request->search,
        ]);
    }

    public function show(Position $position)
    {
        $this->authorize('view', $position);

        return app(ShowPositionResponse::class)->with([
            'position' => $position->load('department'),
        ]);
    }
}
