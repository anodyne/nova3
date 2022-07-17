<?php

declare(strict_types=1);

namespace Nova\Posts\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Posts\Models\Post;
use Nova\Posts\Responses\WritePostResponse;

class CreatePostController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function create(Post $post)
    {
        return WritePostResponse::sendWith([
            'post' => $post,
        ]);
    }
}
