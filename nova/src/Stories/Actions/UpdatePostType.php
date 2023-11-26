<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Data\PostTypeData;
use Nova\Stories\Models\PostType;

class UpdatePostType
{
    use AsAction;

    public function handle(PostType $postType, PostTypeData $data): PostType
    {
        return tap($postType)
            ->update($data->all())
            ->refresh();
    }
}
