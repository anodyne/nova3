<?php

declare(strict_types=1);

namespace Nova\Posts\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Posts\Models\Post;
use Nova\Posts\Models\States\Published;
use Nova\Posts\Responses\CreatePostResponse;
use Nova\Posts\Responses\EditPostResponse;
use Nova\Posts\Responses\ListPostsResponse;
use Nova\Posts\Responses\ShowPostResponse;
use Nova\Stories\Models\Story;

class PostController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');

        $this->authorizeResource(Post::class);
    }

    public function index()
    {
        return ListPostsResponse::send();
    }

    public function show(Story $story, Post $post)
    {
        return ShowPostResponse::sendWith([
            'post' => $post->load('characterAuthors', 'userAuthors'),
            'story' => $story,
            'previousPost' => $post->previousSibling(Published::class),
            'nextPost' => $post->nextSibling(Published::class),
        ]);
    }

    public function create($neighbor = null, $direction = 'after')
    {
        return CreatePostResponse::send();
    }

    public function edit(Post $post)
    {
        return EditPostResponse::sendWith([
            'post' => $post,
        ]);
    }
}
