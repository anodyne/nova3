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

        return CreateDepartmentResponse::send();
    }

    public function store(CreateDepartmentRequest $request)
    {
        $this->authorize('create', Department::class);

        $department = CreateDepartmentManager::run($request);

        return redirect()
            ->route('departments.index')
            ->withToast("{$department->name} department was created");
    }
}
