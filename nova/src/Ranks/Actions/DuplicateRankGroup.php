<?php

namespace Nova\Ranks\Actions;

use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\DataTransferObjects\RankGroupData;

class DuplicateRankGroup
{
    public function execute(RankGroup $originalGroup, RankGroupData $data): RankGroup
    {
        $group = $originalGroup->replicate()->fill($data->toArray());

        $group->save();

        return $group->fresh();
    }
}
