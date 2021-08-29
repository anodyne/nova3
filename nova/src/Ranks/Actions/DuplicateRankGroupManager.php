<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Ranks\DataTransferObjects\RankGroupData;
use Nova\Ranks\DataTransferObjects\RankItemData;
use Nova\Ranks\Models\RankGroup;

class DuplicateRankGroupManager
{
    use AsAction;

    public function handle(RankGroup $original, Request $request): RankGroup
    {
        $group = DuplicateRankGroup::run(
            $original,
            RankGroupData::fromRequest($request)
        );

        DuplicateRankGroupRankItems::run(
            $group,
            $original,
            RankItemData::fromRequest($request)
        );

        return $group->refresh();
    }
}
