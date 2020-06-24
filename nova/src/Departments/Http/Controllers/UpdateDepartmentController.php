<?php

namespace Nova\Departments\Http\Controllers;

use Nova\Departments\Models\Department;
use Nova\Departments\Actions\UpdateDepartment;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Departments\DataTransferObjects\DepartmentData;
use Nova\Departments\Http\Requests\UpdateDepartmentRequest;
use Nova\Departments\Http\Responses\UpdateDepartmentResponse;

class UpdateDepartmentController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function edit(Department $department)
    {
        $this->authorize('update', $department);

        return app(UpdateDepartmentResponse::class)->with([
            'department' => $department,
        ]);
    }

    public function update(
        UpdateDepartmentRequest $request,
        UpdateDepartment $action,
        Department $department
    ) {
        $this->authorize('update', $department);

        $department = $action->execute($department, DepartmentData::fromRequest($request));

        return back()->withToast("{$department->name} department was updated");
    }
}
