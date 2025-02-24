<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Data\PostData;
use Nova\Stories\Models\Post;

class UpdatePost
{
    use AsAction;

    public function handle(Post $post, PostData $data): Post
    {
        return tap($post)
            ->update($data->toArray())
            ->refresh();
    }
}
