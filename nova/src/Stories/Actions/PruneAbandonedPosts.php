<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Stories\Models\Post;

class PruneAbandonedPosts extends Action
{
    public function handle(): int
    {
        return Post::query()->abandoned()->delete();
    }
}
