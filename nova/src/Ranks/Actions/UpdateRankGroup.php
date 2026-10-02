<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Illuminate\Support\Arr;
use Nova\Foundation\Actions\Action;
use Nova\Ranks\Data\RankGroupData;
use Nova\Ranks\Models\RankGroup;

class UpdateRankGroup extends Action
{
    public function handle(RankGroup $group, RankGroupData $data): RankGroup
    {
        return tap($group)
            ->update(Arr::except($data->toArray(), 'base_image'))
            ->refresh();
    }
}
