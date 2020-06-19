<?php

namespace Nova\Ranks\Actions;

use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\DataTransferObjects\RankGroupData;

class UpdateRankGroup
{
    public function execute(RankGroup $group, RankGroupData $data): RankGroup
    {
        return tap($group)->update($data->toArray())->fresh();
    }
}
