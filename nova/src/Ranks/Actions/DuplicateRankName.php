<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Ranks\Data\RankNameData;
use Nova\Ranks\Models\RankName;

class DuplicateRankName
{
    use AsAction;

    public function handle(RankName $original, RankNameData $data): RankName
    {
        $replica = $original->replicate(['ranks_count']);
        $replica->fill($data->toArray());
        $replica->save();

        activity()
            ->performedOn($original)
            ->withProperty('replica', $replica->id)
            ->event('duplicated')
            ->log('duplicated');

        return $replica->refresh();
    }
}
