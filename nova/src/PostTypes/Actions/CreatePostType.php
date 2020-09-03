<?php

namespace Nova\PostTypes\Actions;

use Nova\PostTypes\Models\PostType;
use Nova\PostTypes\DataTransferObjects\PostTypeData;

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
