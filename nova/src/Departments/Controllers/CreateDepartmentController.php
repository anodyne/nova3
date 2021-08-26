<?php

declare(strict_types=1);

namespace Nova\Departments\Controllers;

use Nova\Departments\Actions\CreateDepartmentManager;
use Nova\Departments\Models\Department;
use Nova\Departments\Requests\CreateDepartmentRequest;
use Nova\Departments\Responses\CreateDepartmentResponse;
use Nova\Foundation\Controllers\Controller;

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

    public function store(
        CreateDepartmentRequest $request,
        CreateDepartmentManager $action
    ) {
        $this->authorize('create', Department::class);

        $department = $action->execute($request);

        return redirect()
            ->route('departments.index')
            ->withToast("{$department->name} department was created");
    }
}
