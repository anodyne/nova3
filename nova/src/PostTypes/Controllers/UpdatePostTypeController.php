<?php

namespace Nova\PostTypes\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\PostTypes\Actions\UpdatePostType;
use Nova\PostTypes\DataTransferObjects\PostTypeData;
use Nova\PostTypes\Models\PostType;
use Nova\PostTypes\Requests\UpdatePostTypeRequest;
use Nova\PostTypes\Responses\UpdatePostTypeResponse;
use Nova\Roles\Models\Role;

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
            'fieldTypes' => ['title', 'day', 'time', 'location', 'content', 'rating'],
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
