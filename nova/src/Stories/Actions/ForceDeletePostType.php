<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Stories\Models\PostType;

class ForceDeletePostType extends Action
{
    public function handle(PostType $postType): PostType
    {
        return tap($postType)->forceDelete();
    }
}
