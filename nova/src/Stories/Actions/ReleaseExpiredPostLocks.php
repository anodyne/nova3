<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Stories\Models\Post;

class ReleaseExpiredPostLocks extends Action
{
    public function handle(): void
    {
        Post::query()
            ->hasExpiredPostLock()
            ->update([
                'locked_at' => null,
                'locked_by' => null,
            ]);
    }
}
