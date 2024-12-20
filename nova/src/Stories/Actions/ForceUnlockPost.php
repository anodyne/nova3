<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Models\Post;

class ForceUnlockPost
{
    use AsAction;

    public function handle(Post $post): void
    {
        $post->unlock();
    }
}
