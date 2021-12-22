<?php

declare(strict_types=1);

namespace Nova\PostTypes\Actions;

use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\PostTypes\Data\PostTypeData;
use Nova\PostTypes\Models\PostType;

class UpdatePostType
{
    use AsAction;

    public function handle(PostType $postType, PostTypeData $data): PostType
    {
        return tap($postType)
            ->update(array_merge(
                Arr::except($data->all(), ['fields', 'options']),
                [
                    'fields' => $data->fields,
                    'options' => $data->options,
                ]
            ))
            ->refresh();
    }
}
