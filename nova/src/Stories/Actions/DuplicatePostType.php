<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Data\PostTypeData;
use Nova\Stories\Models\PostType;

class DuplicatePostType
{
    use AsAction;

    public function handle(PostType $original, PostTypeData $data): PostType
    {
        $postType = $original->replicate(['posts_count', 'published_posts_count', 'prefixed_id']);
        $postType->fill([
            'name' => $data->name,
            'key' => $data->key,
        ]);
        $postType->save();

        return $postType->refresh();
    }
}
