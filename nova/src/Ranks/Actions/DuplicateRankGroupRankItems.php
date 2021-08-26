<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Nova\Ranks\DataTransferObjects\RankItemData;
use Nova\Ranks\Models\RankGroup;

class DuplicateRankGroupRankItems
{
    public function execute(
        RankGroup $group,
        RankGroup $originalGroup,
        RankItemData $data
    ) {
        $originalGroup->ranks->each(function ($rank) use ($group, $data) {
            $group->ranks()->create(array_merge(
                $rank->toArray(),
                $data->only('base_image')->toArray()
            ));
        });
    }
}
