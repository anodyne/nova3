<?php

declare(strict_types=1);

namespace Nova\Departments\Controllers;

use Nova\Departments\Actions\UpdateDepartmentManager;
use Nova\Departments\Models\Department;
use Nova\Departments\Requests\UpdateDepartmentRequest;
use Nova\Departments\Responses\UpdateDepartmentResponse;
use Nova\Foundation\Controllers\Controller;

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
        UpdateDepartmentManager $action,
        Department $department
    ) {
        $this->authorize('update', $department);

        $department = $action->execute($department, $request);

        return back()->withToast("{$department->name} department was updated");
    }
}
