<?php

declare(strict_types=1);

namespace Nova\PostTypes\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Posts\Models\Post;
use Nova\PostTypes\Models\PostType;

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
