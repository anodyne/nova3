<?php

namespace Nova\Ranks\Actions;

use Nova\Ranks\Models\RankItem;
use Nova\Ranks\DataTransferObjects\RankItemData;

class UpdateRankItem
{
    public function execute(RankItem $item, RankItemData $data): RankItem
    {
        return tap($item)->update($data->toArray())->fresh();
    }
}
