<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Nova\Ranks\Models\RankName;

class ReorderRankNames
{
    public function execute(string $sort): void
    {
        collect(explode(',', $sort))->each(function ($id, $index) {
            RankName::where('id', $id)->update(['sort' => $index]);
        });
    }
}
