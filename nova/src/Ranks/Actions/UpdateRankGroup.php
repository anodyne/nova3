<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Ranks\Data\RankGroupData;
use Nova\Ranks\Models\RankGroup;

class UpdateRankGroup
{
    use AsAction;

    public function handle(RankGroup $group, RankGroupData $data): RankGroup
    {
        return tap($group)
            ->update(Arr::except($data->toArray(), 'base_image'))
            ->refresh();
    }
}
