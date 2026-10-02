<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Ranks\Data\RankItemData;
use Nova\Ranks\Models\RankItem;

class CreateRankItem extends Action
{
    public function handle(RankItemData $data): RankItem
    {
        return RankItem::create($data->toArray());
    }
}
