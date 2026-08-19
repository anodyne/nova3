<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Models\Post;
use Nova\Users\Models\User;

class LockPost
{
    use AsAction;

    public function handle(Post $post, User $user): void
    {
        if ($post->participatingUsers()->count() === 1) {
            return;
        }

        if (! $post->isLocked() || $post->lockIsOwnedBy($user)) {
            $post->lock($user);
        }
    }
}
