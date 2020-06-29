<?php

namespace Nova\Ranks\Actions;

use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\DataTransferObjects\RankGroupData;

class CreateRankGroup
{
    public function execute(RankGroupData $data): RankGroup
    {
        return RankGroup::create(array_merge(
            $data->toArray(),
            ['sort' => RankGroup::count()]
        ));
    }
}
