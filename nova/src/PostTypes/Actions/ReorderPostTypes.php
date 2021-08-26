<?php

declare(strict_types=1);

namespace Nova\PostTypes\Actions;

use Nova\PostTypes\Models\PostType;

class ReorderPostTypes
{
    public function execute(string $sort): void
    {
        collect(explode(',', $sort))->each(function ($postTypeId, $index) {
            PostType::where('id', $postTypeId)->update(['sort' => $index]);
        });
    }
}
