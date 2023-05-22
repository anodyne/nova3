<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Ranks\Data\RankGroupData;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Models\RankItem;

class DuplicateRankGroup
{
    use AsAction;

    public function handle(RankGroup $original, RankGroupData $data): RankGroup
    {
        $group = $original->replicate();
        $group->fill($data->all());
        $group->save();

        $original->ranks->each(
            fn (RankItem $rank) => $group->ranks()->create(array_merge(
                $rank->toArray(),
                $data->only('base_image')->all()
            ))
        );

        return $group->refresh();
    }
}
