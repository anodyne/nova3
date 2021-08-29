<?php

declare(strict_types=1);

namespace Nova\PostTypes\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\PostTypes\Models\PostType;

class ReorderPostTypes
{
    use AsAction;

    public function handle(string $sort): void
    {
        collect(explode(',', $sort))->each(function ($postTypeId, $index) {
            PostType::where('id', $postTypeId)->update(['sort' => $index]);
        });
    }
}
