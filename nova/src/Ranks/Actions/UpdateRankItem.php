<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Ranks\DataTransferObjects\RankItemData;
use Nova\Ranks\Models\RankItem;

class UpdateRankItem
{
    use AsAction;

    public function handle(RankItem $item, RankItemData $data): RankItem
    {
        return tap($item)->update($data->toArray())->fresh();
    }
}
