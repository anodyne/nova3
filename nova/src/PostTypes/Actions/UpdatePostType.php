<?php

declare(strict_types=1);

namespace Nova\PostTypes\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\PostTypes\Data\PostTypeData;
use Nova\PostTypes\Models\PostType;

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
