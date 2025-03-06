<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Bag\Bag;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Models\Post;

class UpdatePost
{
    use AsAction;

    public function handle(Post $post, Bag $data): Post
    {
        return tap($post)
            ->update($data->toArray())
            ->refresh();
    }
}
