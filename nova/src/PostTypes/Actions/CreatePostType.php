<?php

declare(strict_types=1);

namespace Nova\PostTypes\Actions;

use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\PostTypes\Data\PostTypeData;
use Nova\PostTypes\Models\PostType;

class CreatePostType
{
    use AsAction;

    public function handle(PostTypeData $data): PostType
    {
        return PostType::create(array_merge(
            Arr::except($data->all(), ['fields', 'options']),
            [
                'fields' => $data->fields,
                'options' => $data->options,
                'sort' => PostType::count(),
            ]
        ));
    }
}
