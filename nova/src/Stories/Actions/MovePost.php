<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\Story;

class MovePost extends Action
{
    public function handle(Post $post, Story $story): Post
    {
        return tap($post)->update(['story_id' => $story->id]);
    }
}
