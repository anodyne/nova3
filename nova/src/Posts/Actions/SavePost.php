<?php

declare(strict_types=1);

namespace Nova\Posts\Actions;

use Nova\Posts\DataTransferObjects\PostData;
use Nova\Posts\Models\Post;

class SavePost
{
    public function execute(PostData $data): Post
    {
        return Post::updateOrCreate(
            $data->only('id')->toArray(),
            $data->except('id')->toArray()
        );
    }
}
