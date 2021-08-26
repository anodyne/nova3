<?php

declare(strict_types=1);

namespace Nova\Posts\Actions;

use Nova\Posts\Models\Post;
use Nova\Stories\Models\Story;

class CreateRootPost
{
    public function execute(Story $story): Post
    {
        return $story->posts()->create([
            'title' => "{$story->title} Root Post",
        ]);
    }
}
