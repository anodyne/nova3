<?php

namespace Nova\Ranks\Actions;

use Nova\Ranks\Models\RankGroup;

class DeleteRankGroup
{
    public function execute(RankGroup $group): RankGroup
    {
        return tap($group)->delete();
    }
}
