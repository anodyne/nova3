<?php

declare(strict_types=1);

namespace Nova\PostTypes\Actions;

use Nova\PostTypes\DataTransferObjects\PostTypeData;
use Nova\PostTypes\Models\PostType;

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
