<?php

declare(strict_types=1);

namespace Nova\PostTypes\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\PostTypes\Models\PostType;

class ReorderPostTypes
{
    use AsAction;

    public function handle(array $items): void
    {
        collect($items)
            ->map(fn ($item) => $item['value'])
            ->each(
                fn ($id, $index) => PostType::where('id', $id)->update(['sort' => $index])
            );
    }
}
