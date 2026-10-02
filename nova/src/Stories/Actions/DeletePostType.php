<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Stories\Models\PostType;

class DeletePostType extends Action
{
    public function handle(PostType $postType): PostType
    {
        if ($postType->posts()->count() === 0) {
            return tap($postType)->forceDelete();
        }

        return tap($postType)->delete();
    }
}
