<?php

declare(strict_types=1);

namespace Nova\PostTypes\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\PostTypes\Actions\CreatePostType;
use Nova\PostTypes\Data\PostTypeData;
use Nova\PostTypes\Models\PostType;
use Nova\PostTypes\Requests\CreatePostTypeRequest;
use Nova\PostTypes\Responses\CreatePostTypeResponse;
use Nova\Roles\Models\Role;

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

        return CreatePostTypeResponse::sendWith([
            'fieldTypes' => ['title', 'location', 'day', 'time', 'content', 'rating', 'summary'],
            'roles' => Role::ordered()->get(),
        ]);
    }

    public function store(CreatePostTypeRequest $request)
    {
        $this->authorize('create', PostType::class);

        $postType = CreatePostType::run(PostTypeData::from($request));

        return redirect()
            ->route('post-types.index')
            ->withToast("{$postType->name} post type was created");
    }
}
