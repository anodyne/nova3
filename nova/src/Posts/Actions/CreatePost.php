<?php

namespace Nova\Posts\Actions;

use Nova\Posts\DataTransferObjects\PostData;
use Nova\Posts\Models\Post;

class CreatePost
{
    public function execute(PostData $data): Post
    {
        return Post::create($data->toArray());
    }
}
