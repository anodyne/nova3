<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Nova\Ranks\DataTransferObjects\RankNameData;
use Nova\Ranks\Models\RankName;

class CreateRankName
{
    public function execute(RankNameData $data): RankName
    {
        return RankName::create(array_merge(
            $data->toArray(),
            ['sort' => RankName::count()]
        ));
    }
}
