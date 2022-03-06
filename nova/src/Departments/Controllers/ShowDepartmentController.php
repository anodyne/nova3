<?php

declare(strict_types=1);

namespace Nova\Departments\Controllers;

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

    public function all()
    {
        $this->authorize('viewAny', Department::class);

        return ShowAllDepartmentsResponse::sendWith([
            'department' => new Department(),
            'departmentCount' => Department::count(),
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
