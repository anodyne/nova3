<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Nova\Ranks\DataTransferObjects\RankGroupData;
use Nova\Ranks\Models\RankGroup;

class DuplicateRankGroup
{
    public function execute(RankGroup $originalGroup, RankGroupData $data): RankGroup
    {
        $group = $originalGroup->replicate()->fill($data->toArray());

        $group->save();

        return $group->fresh();
    }
}
