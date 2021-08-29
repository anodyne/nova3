<?php

declare(strict_types=1);

namespace Nova\PostTypes\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\PostTypes\DataTransferObjects\PostTypeData;
use Nova\PostTypes\Models\PostType;

class CreatePostType
{
    use AsAction;

    public function handle(PostTypeData $data): PostType
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
