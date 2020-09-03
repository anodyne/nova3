<?php

namespace Nova\PostTypes\Actions;

use Nova\PostTypes\Models\PostType;
use Nova\PostTypes\DataTransferObjects\PostTypeData;

class UpdatePostType
{
    public function execute(PostType $postType, PostTypeData $data): PostType
    {
        return tap($postType)
            ->update(array_merge(
                $data->except('fields', 'options')->toArray(),
                [
                    'fields' => $data->fields,
                    'options' => $data->options,
                ]
            ))
            ->refresh();
    }
}
