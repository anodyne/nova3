<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Illuminate\Support\Arr;
use Nova\Foundation\Actions\Action;
use Nova\Ranks\Data\RankGroupData;
use Nova\Ranks\Models\RankGroup;

class CreateRankGroup extends Action
{
    public function handle(RankGroupData $data): RankGroup
    {
        return RankGroup::create(
            Arr::except($data->toArray(), 'base_image')
        );
    }
}
