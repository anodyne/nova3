<?php

namespace Nova\Posts\Actions;

use Nova\Posts\Models\Post;

class DeletePost
{
    public function execute(Post $post): Post
    {
        return tap($post)->delete();
    }
}
