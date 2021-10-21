<?php

declare(strict_types=1);

namespace Nova\Departments\Controllers;

use Illuminate\Http\Request;
use Nova\Departments\Filters\DepartmentFilters;
use Nova\Departments\Models\Department;
use Nova\Departments\Responses\ShowAllDepartmentsResponse;
use Nova\Departments\Responses\ShowDepartmentResponse;
use Nova\Foundation\Controllers\Controller;

class ShowDepartmentController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function all(Request $request, DepartmentFilters $filters)
    {
        $this->authorize('viewAny', Department::class);

        $departments = Department::withCount('positions')
            ->filter($filters)
            ->orderBySort();

        $departments = ($request->has('reorder'))
            ? $departments->get()
            : $departments->paginate();

        return ShowAllDepartmentsResponse::sendWith([
            'departmentCount' => Department::count(),
            'departments' => $departments,
            'isReordering' => $request->has('reorder'),
            'search' => $request->search,
        ]);
    }

    public function show(Department $department)
    {
        $this->authorize('view', $department);

        return ShowDepartmentResponse::sendWith([
            'department' => $department->load('positions'),
        ]);
    }
}
