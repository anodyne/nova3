<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Ranks\Models\RankItem;

class DeleteRankItem extends Action
{
    public function handle(RankItem $item): RankItem
    {
        return tap($item)->delete();
    }
}
