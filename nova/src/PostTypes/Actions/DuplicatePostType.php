<?php

declare(strict_types=1);

namespace Nova\PostTypes\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\PostTypes\Data\PostTypeData;
use Nova\PostTypes\Models\PostType;

class DuplicatePostType
{
    use AsAction;

    public function handle(PostType $original, PostTypeData $data): PostType
    {
        $replica = $original->replicate();
        $replica->fill([
            'name' => $data->name,
            'key' => $data->key,
        ]);
        $replica->save();

        return $replica->refresh();
    }
}
