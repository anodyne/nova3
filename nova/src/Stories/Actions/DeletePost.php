<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Stories\Models\Post;

class DeletePost extends Action
{
    public function handle(Post $post): Post
    {
        $post->characterAuthors()->detach();

        $post->userAuthors()->detach();

        return tap($post)->delete();
    }
}
