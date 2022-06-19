<?php

declare(strict_types=1);

namespace Nova\Posts\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Posts\Models\Post;
use Nova\Posts\Responses\ShowPostResponse;
use Nova\Stories\Models\Story;
use Nova\Users\Models\User;

class ShowPostController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function show(Story $story, Post $post)
    {
        $this->authorize('view', $post);

        return ShowPostResponse::sendWith([
            'post' => $post->load('type', 'characterAuthors', 'userAuthors'),
            'story' => $story,
            'previousPost' => $post->prevSiblings()->wherePublished()->first(),
            'nextPost' => $post->nextSiblings()->wherePublished()->first(),
        ]);
    }
}
