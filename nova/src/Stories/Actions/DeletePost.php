<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Models\Post;

class DeletePost
{
    use AsAction;

    public function handle(Post $post): Post
    {
        return tap($post)->delete();
    }
}
