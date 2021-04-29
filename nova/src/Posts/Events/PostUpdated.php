<?php

namespace Nova\Posts\Events;

use Nova\Posts\Models\Post;

class PostUpdated
{
    public Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }
}
