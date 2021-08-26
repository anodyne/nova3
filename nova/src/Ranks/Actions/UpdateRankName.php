<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Nova\Ranks\DataTransferObjects\RankNameData;
use Nova\Ranks\Models\RankName;

class UpdateRankName
{
    public function execute(RankName $name, RankNameData $data): RankName
    {
        return tap($name)->update($data->toArray())->fresh();
    }
}
