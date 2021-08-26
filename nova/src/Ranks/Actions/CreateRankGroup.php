<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Nova\Ranks\DataTransferObjects\RankGroupData;
use Nova\Ranks\Models\RankGroup;

class CreateRankGroup
{
    public function execute(RankGroupData $data): RankGroup
    {
        return RankGroup::create(array_merge(
            $data->toArray(),
            ['sort' => RankGroup::count()]
        ));
    }
}
