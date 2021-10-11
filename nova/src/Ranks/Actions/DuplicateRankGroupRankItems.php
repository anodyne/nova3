<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Ranks\DataTransferObjects\RankItemData;
use Nova\Ranks\Models\RankGroup;

class DuplicateRankGroupRankItems
{
    use AsAction;

    public function handle(
        RankGroup $group,
        RankGroup $original,
        RankItemData $data
    ): void {
        $original->ranks->each(function ($rank) use ($group, $data) {
            $group->ranks()->create(array_merge(
                $rank->toArray(),
                $data->only('base_image')->toArray()
            ));
        });
    }
}
