<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Nova\Ranks\DataTransferObjects\RankItemData;
use Nova\Ranks\Models\RankItem;

class UpdateRankItem
{
    public function execute(RankItem $item, RankItemData $data): RankItem
    {
        return tap($item)->update($data->toArray())->fresh();
    }
}
