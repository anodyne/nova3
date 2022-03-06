<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Ranks\Models\RankName;

class ReorderRankNames
{
    use AsAction;

    public function handle(array $items): void
    {
        collect($items)
            ->map(fn ($item) => $item['value'])
            ->each(fn ($id, $index) => RankName::where('id', $id)->update(['sort' => $index]));
    }
}
