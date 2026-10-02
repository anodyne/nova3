<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Bag\Bag;
use Nova\Foundation\Actions\Action;
use Nova\Stories\Models\Post;

class UpdatePost extends Action
{
    public function handle(Post $post, Bag $data): Post
    {
        return tap($post)
            ->update($data->toArray())
            ->refresh();
    }
}
