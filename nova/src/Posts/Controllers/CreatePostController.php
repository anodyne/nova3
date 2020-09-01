<?php

namespace Nova\Posts\Controllers;

use Nova\Posts\Models\Post;
use Nova\Stories\Models\Story;
use Nova\PostTypes\Models\PostType;
use Nova\Foundation\Controllers\Controller;
use Nova\Posts\Responses\CreatePostResponse;
use Nova\Posts\Responses\PickPostTypeResponse;

class CreatePostController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function pickPostType()
    {
        $this->authorize('create', new Post);

        return app(PickPostTypeResponse::class)->with([
            'postTypes' => PostType::orderBySort()->get(),
        ]);
    }

    public function create(PostType $postType)
    {
        $this->authorize('write', [new Post, $postType]);

        return app(CreatePostResponse::class)->with([
            'postType' => $postType,
            'stories' => Story::whereCurrent()->get(),
        ]);
    }

    public function store(PostType $postType)
    {
        $this->authorize('write', [new Post, $postType]);
    }
}
