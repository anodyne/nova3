<?php

namespace Nova\Ranks\Actions;

use Nova\Ranks\Models\RankName;
use Nova\Ranks\DataTransferObjects\RankNameData;

class CreateRankName
{
    public function execute(RankNameData $data): RankName
    {
        return RankName::create($data->toArray());
    }
}
