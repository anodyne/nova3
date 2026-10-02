<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Stories\Models\Post;

class ForceUnlockPost extends Action
{
    public function handle(Post $post): void
    {
        $post->unlock();
    }
}
