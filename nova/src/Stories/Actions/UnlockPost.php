<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Stories\Models\Post;
use Nova\Users\Models\User;

class UnlockPost extends Action
{
    public function handle(Post $post, User $user): void
    {
        if ($post->isLocked() && $post->lockIsOwnedBy($user)) {
            $post->unlock();
        }
    }
}
