<?php

namespace Nova\PostTypes\Controllers;

use Nova\PostTypes\Models\PostType;
use Nova\Departments\Models\Department;
use Nova\Foundation\Controllers\Controller;
use Nova\Departments\Actions\CreateDepartment;
use Nova\PostTypes\Responses\UpdatePostTypeResponse;
use Nova\Departments\Requests\CreateDepartmentRequest;
use Nova\Departments\DataTransferObjects\DepartmentData;

class UpdatePostTypeController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function edit(PostType $postType)
    {
        $this->authorize('update', $postType);

        return app(UpdatePostTypeResponse::class)->with([
            'postType' => $postType,
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
