<?php

namespace Nova\Ranks\Actions;

use Nova\Ranks\Models\RankGroup;

class DuplicateRankGroup
{
    public function execute(RankGroup $originalGroup): RankGroup
    {
        $group = $originalGroup->replicate();

        $group->name = "Copy of {$originalGroup->name}";

        $group->save();

        return $group->refresh();
    }
}
