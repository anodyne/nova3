<?php

declare(strict_types=1);

namespace Nova\Posts\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Posts\Models\Post;
use Nova\Stories\Models\Story;

class MovePost
{
    use AsAction;

    public function handle(Post $post, Story $story): Post
    {
        return tap($post)->update(['story_id' => $story->id]);
    }
}
