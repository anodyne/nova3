<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Ranks\Data\RankGroupData;
use Nova\Ranks\Data\RankItemData;
use Nova\Ranks\Models\RankGroup;

class DuplicateRankGroupManager
{
    use AsAction;

    public function handle(RankGroup $original, Request $request): RankGroup
    {
        $group = DuplicateRankGroup::run(
            $original,
            RankGroupData::from($request)
        );

        DuplicateRankGroupRankItems::run(
            $group,
            $original,
            RankItemData::from($request)
        );

        return $group->refresh();
    }
}
