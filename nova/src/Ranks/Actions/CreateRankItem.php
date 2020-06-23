<?php

namespace Nova\Ranks\Actions;

use Nova\Ranks\Models\RankItem;
use Nova\Ranks\DataTransferObjects\RankItemData;

class CreateRankItem
{
    public function execute(RankItemData $data): RankItem
    {
        return RankItem::create($data->toArray());
    }
}
