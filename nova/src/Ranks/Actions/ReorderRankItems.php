<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Nova\Ranks\Models\RankItem;

class ReorderRankItems
{
    public function execute(string $sort): void
    {
        collect(explode(',', $sort))->each(function ($nameId, $index) {
            RankItem::where('id', $nameId)->update(['sort' => $index]);
        });
    }
}
