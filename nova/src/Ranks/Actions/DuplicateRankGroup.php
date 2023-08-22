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
        $replica = $original->replicate();
        $replica->fill($data->all());
        $replica->save();

        $original->ranks->each(
            fn (RankItem $rank) => $replica->ranks()->create(array_merge(
                $rank->toArray(),
                $data->only('base_image')->all()
            ))
        );

        return $replica->refresh();
    }
}
