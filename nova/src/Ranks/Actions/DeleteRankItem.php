<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Ranks\Models\RankItem;

class DeleteRankItem
{
    use AsAction;

    public function handle(RankItem $item): RankItem
    {
        return tap($item)->delete();
    }
}
