<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Ranks\Data\RankNameData;
use Nova\Ranks\Models\RankName;

class DuplicateRankName extends Action
{
    public function handle(RankName $original, RankNameData $data): RankName
    {
        $rankName = $original->replicate(['ranks_count']);
        $rankName->fill($data->toArray());
        $rankName->save();

        activity()
            ->performedOn($original)
            ->withProperty('replica', $rankName->id)
            ->event('duplicated')
            ->log('duplicated');

        return $rankName->refresh();
    }
}
