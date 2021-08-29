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
        collect(explode(',', $sort))->each(function ($id, $index) {
            PostType::where('id', $id)->update(['sort' => $index]);
        });
    }
}
