<?php

namespace Nova\Ranks\Actions;

use Nova\Ranks\Models\RankName;
use Nova\Ranks\DataTransferObjects\RankNameData;

class UpdateRankName
{
    public function execute(RankName $name, RankNameData $data): RankName
    {
        return tap($name)->update($data->toArray())->fresh();
    }
}
