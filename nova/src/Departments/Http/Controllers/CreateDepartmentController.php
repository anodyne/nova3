<?php

namespace Nova\Departments\Http\Controllers;

use Nova\Departments\Models\Department;
use Nova\Departments\Actions\CreateDepartment;
use Nova\Departments\DataTransferObjects\DepartmentData;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Departments\Http\Requests\CreateDepartmentRequest;
use Nova\Departments\Http\Responses\CreateDepartmentResponse;

class CreateDepartmentController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function create()
    {
        $this->authorize('create', Department::class);

        return app(CreateDepartmentResponse::class);
    }

    public function store(CreateDepartmentRequest $request, CreateDepartment $action)
    {
        $this->authorize('create', Department::class);

        $department = $action->execute(DepartmentData::fromRequest($request));

        return redirect()
            ->route('departments.index')
            ->withToast("{$department->name} department was created");
    }
}
