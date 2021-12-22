<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Ranks\Data\RankItemData;
use Nova\Ranks\Models\RankItem;

class CreateRankItem
{
    use AsAction;

    public function handle(RankItemData $data): RankItem
    {
        return RankItem::create($data->all());
    }
}
