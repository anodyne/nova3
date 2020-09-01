<?php

namespace Nova\Posts\Actions;

use Nova\Posts\Models\Post;
use Nova\Stories\Models\Story;

class MovePost
{
    public function execute(Post $post, Story $story): Post
    {
        return tap($post)->update(['story_id' => $story->id]);
    }
}
