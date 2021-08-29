<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Ranks\DataTransferObjects\RankGroupData;
use Nova\Ranks\Models\RankGroup;

class DuplicateRankGroup
{
    use AsAction;

    public function handle(RankGroup $original, RankGroupData $data): RankGroup
    {
        $group = $original->replicate()->fill($data->toArray());

        $group->save();

        return $group->fresh();
    }
}
