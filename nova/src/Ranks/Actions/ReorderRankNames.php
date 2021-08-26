<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Nova\Ranks\Models\RankName;

class ReorderRankNames
{
    public function execute(string $sort): void
    {
        collect(explode(',', $sort))->each(function ($nameId, $index) {
            RankName::where('id', $nameId)->update(['sort' => $index]);
        });
    }
}
