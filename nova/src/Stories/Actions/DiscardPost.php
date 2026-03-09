<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Models\Post;

class DiscardPost
{
    use AsAction;

    public function handle(Post $post): Post
    {
        $post->characterAuthors()->detach();

        $post->userAuthors()->detach();

        return tap($post)->forceDelete();
    }
}
