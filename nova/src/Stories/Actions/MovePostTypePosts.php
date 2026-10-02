<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostType;

class MovePostTypePosts extends Action
{
    public function handle(PostType $oldPostType, ?PostType $newPostType): void
    {
        Post::query()
            ->where('post_type_id', $oldPostType->id)
            ->update(['post_type_id' => $newPostType?->id]);
    }
}
