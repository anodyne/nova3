<?php

declare(strict_types=1);

namespace Nova\PostTypes\Actions;

use Nova\PostTypes\DataTransferObjects\PostTypeData;
use Nova\PostTypes\Models\PostType;

class CreatePostType
{
    public function execute(PostTypeData $data): PostType
    {
        return PostType::create(array_merge(
            $data->except('fields', 'options')->toArray(),
            [
                'fields' => $data->fields,
                'options' => $data->options,
                'sort' => PostType::count(),
            ]
        ));
    }
}
