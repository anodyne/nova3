<?php

namespace Nova\Ranks\Actions;

use Nova\Ranks\Models\RankGroup;

class ReorderRankGroups
{
    public function execute(string $sort): void
    {
        collect(explode(',', $sort))->each(function ($groupId, $index) {
            RankGroup::where('id', $groupId)->update(['sort' => $index]);
        });
    }
}
