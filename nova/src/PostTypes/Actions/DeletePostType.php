<?php

declare(strict_types=1);

namespace Nova\PostTypes\Actions;

use Nova\PostTypes\Models\PostType;

class DeletePostType
{
    public function execute(PostType $postType): PostType
    {
        return tap($postType)->delete();
    }
}
