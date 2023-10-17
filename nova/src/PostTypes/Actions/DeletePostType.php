<?php

declare(strict_types=1);

namespace Nova\PostTypes\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\PostTypes\Models\PostType;

class DeletePostType
{
    use AsAction;

    public function handle(PostType $postType): PostType
    {
        if ($postType->posts()->count() === 0) {
            return tap($postType)->forceDelete();
        }

        return tap($postType)->delete();
    }
}
