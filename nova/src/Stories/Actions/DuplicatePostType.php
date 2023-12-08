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
        $replica = $original->replicate(['posts_count', 'published_posts_count']);
        $replica->fill([
            'name' => $data->name,
            'key' => $data->key,
        ]);
        $replica->save();

        return $replica->refresh();
    }
}
