<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Nova\Ranks\DataTransferObjects\RankGroupData;
use Nova\Ranks\Models\RankGroup;

class UpdateRankGroup
{
    public function execute(RankGroup $group, RankGroupData $data): RankGroup
    {
        return tap($group)->update($data->toArray())->fresh();
    }
}
