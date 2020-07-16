<?php

namespace Nova\PostTypes\Controllers;

use Nova\Roles\Models\Role;
use Nova\PostTypes\Models\PostType;
use Nova\Departments\Models\Department;
use Nova\Foundation\Controllers\Controller;
use Nova\Departments\Actions\CreateDepartment;
use Nova\PostTypes\Responses\CreatePostTypeResponse;
use Nova\Departments\Requests\CreateDepartmentRequest;
use Nova\Departments\DataTransferObjects\DepartmentData;

class CreatePostTypeController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function create()
    {
        $this->authorize('create', PostType::class);

        return app(CreatePostTypeResponse::class)->with([
            'roles' => Role::orderBySort()->get(),
        ]);
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
