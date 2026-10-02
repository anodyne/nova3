<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Ranks\Data\RankItemData;
use Nova\Ranks\Models\RankItem;

class UpdateRankItem extends Action
{
    public function handle(RankItem $item, RankItemData $data): RankItem
    {
        return tap($item)
            ->update($data->toArray())
            ->refresh();
    }
}
