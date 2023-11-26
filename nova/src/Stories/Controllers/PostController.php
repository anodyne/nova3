<?php

declare(strict_types=1);

namespace Nova\Stories\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\States\PostStatus\Published;
use Nova\Stories\Models\Story;
use Nova\Stories\Responses\CreatePostResponse;
use Nova\Stories\Responses\EditPostResponse;
use Nova\Stories\Responses\ListPostsResponse;
use Nova\Stories\Responses\ShowPostResponse;

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
