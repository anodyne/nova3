<?php

declare(strict_types=1);

namespace Nova\Posts\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Posts\Models\Post;

class DeletePost
{
    use AsAction;

    public function handle(Post $post): Post
    {
        return tap($post)->delete();
    }
}
