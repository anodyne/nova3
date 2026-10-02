<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\States\PostStatus\Published;

class ApprovePost extends Action
{
    public function handle(Post $original): Post
    {
        $post = Post::find($original->id);

        $post->status->transitionTo(Published::class);

        return $post->fresh();
    }
}
