<?php

namespace Nova\PostTypes\Controllers;

use Nova\Roles\Models\Role;
use Nova\PostTypes\Models\PostType;
use Nova\Departments\Models\Department;
use Nova\Foundation\Controllers\Controller;
use Nova\Departments\Actions\CreateDepartment;
use Nova\PostTypes\Responses\UpdatePostTypeResponse;
use Nova\Departments\Requests\CreateDepartmentRequest;
use Nova\Departments\DataTransferObjects\DepartmentData;
use Nova\PostTypes\Actions\UpdatePostType;
use Nova\PostTypes\DataTransferObjects\PostTypeData;
use Nova\PostTypes\Requests\UpdatePostTypeRequest;

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
            'roles' => Role::orderBySort()->get(),
        ]);
    }

    public function update(
        UpdatePostTypeRequest $request,
        UpdatePostType $action,
        PostType $postType
    ) {
        $this->authorize('update', $postType);

        $postType = $action->execute(
            $postType,
            PostTypeData::fromRequest($request)
        );

        return redirect()
            ->route('post-types.edit', $postType)
            ->withToast("{$postType->name} was updated");
    }
}
