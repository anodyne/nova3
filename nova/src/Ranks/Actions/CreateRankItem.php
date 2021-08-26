<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Nova\Ranks\DataTransferObjects\RankItemData;
use Nova\Ranks\Models\RankItem;

class CreateRankItem
{
    public function execute(RankItemData $data): RankItem
    {
        return RankItem::create($data->toArray());
    }
}
