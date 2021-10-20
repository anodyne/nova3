<?php

declare(strict_types=1);

namespace Nova\Posts\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Posts\Models\Post;
use Nova\Posts\Responses\ComposePostResponse;
use Nova\PostTypes\Models\PostType;
use Nova\Stories\Models\Story;

class CreatePostController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function create(PostType $postType)
    {
        $this->authorize('write', [new Post(), $postType]);

        return ComposePostResponse::sendWith([
            'postType' => $postType,
            'stories' => Story::wherePostable()->get(),
        ]);
    }
}
