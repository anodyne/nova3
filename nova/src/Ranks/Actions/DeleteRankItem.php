<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Nova\Ranks\Models\RankItem;

class DeleteRankItem
{
    public function execute(RankItem $item): RankItem
    {
        return tap($item)->delete();
    }
}
