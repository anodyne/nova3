<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Nova\Ranks\Models\RankGroup;

class ReorderRankGroups
{
    public function execute(string $sort): void
    {
        collect(explode(',', $sort))->each(function ($id, $index) {
            RankGroup::where('id', $id)->update(['sort' => $index]);
        });
    }
}
