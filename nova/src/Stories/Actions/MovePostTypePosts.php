<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostType;

class MovePostTypePosts
{
    use AsAction;

    public function handle(PostType $oldPostType, ?PostType $newPostType): void
    {
        Post::query()
            ->where('post_type_id', $oldPostType->id)
            ->update(['post_type_id' => $newPostType?->id]);
    }
}
