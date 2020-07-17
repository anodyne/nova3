<?php

namespace Nova\PostTypes\Controllers;

use Nova\Roles\Models\Role;
use Nova\PostTypes\Models\PostType;
use Nova\PostTypes\Actions\CreatePostType;
use Nova\Foundation\Controllers\Controller;
use Nova\PostTypes\Requests\CreatePostTypeRequest;
use Nova\PostTypes\DataTransferObjects\PostTypeData;
use Nova\PostTypes\Responses\CreatePostTypeResponse;

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

    public function store(CreatePostTypeRequest $request, CreatePostType $action)
    {
        $this->authorize('create', PostType::class);

        $postType = $action->execute(PostTypeData::fromRequest($request));

        return redirect()
            ->route('post-types.index')
            ->withToast("{$postType->name} post type was created");
    }
}
