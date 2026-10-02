<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Stories\Data\PostTypeData;
use Nova\Stories\Models\PostType;

class CreatePostType extends Action
{
    public function handle(PostTypeData $data): PostType
    {
        return PostType::create($data->toArray());
    }
}
