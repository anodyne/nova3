<?php

declare(strict_types=1);

namespace Nova\Stories\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Stories\Data\PostTypeData;
use Nova\Stories\Models\PostType;

class CreatePostType
{
    use AsAction;

    public function handle(PostTypeData $data): PostType
    {
        return PostType::create($data->all());
    }
}
