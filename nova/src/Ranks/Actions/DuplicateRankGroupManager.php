<?php

namespace Nova\Ranks\Actions;

use Illuminate\Http\Request;
use Nova\Ranks\DataTransferObjects\RankGroupData;
use Nova\Ranks\DataTransferObjects\RankItemData;
use Nova\Ranks\Models\RankGroup;

class DuplicateRankGroupManager
{
    protected $duplicateRankGroup;

    protected $duplicateRankGroupRankItems;

    public function __construct(
        DuplicateRankGroup $duplicateRankGroup,
        DuplicateRankGroupRankItems $duplicateRankGroupRankItems
    ) {
        $this->duplicateRankGroup = $duplicateRankGroup;
        $this->duplicateRankGroupRankItems = $duplicateRankGroupRankItems;
    }

    public function execute(RankGroup $originalGroup, Request $request): RankGroup
    {
        $group = $this->duplicateRankGroup->execute(
            $originalGroup,
            RankGroupData::fromRequest($request)
        );

        $this->duplicateRankGroupRankItems->execute(
            $group,
            $originalGroup,
            RankItemData::fromRequest($request)
        );

        return $group->refresh();
    }
}
