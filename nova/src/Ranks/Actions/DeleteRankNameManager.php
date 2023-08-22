<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankName;

class DeleteRankNameManager
{
    use AsAction;

    public function handle(RankName $name): RankName
    {
        $name->ranks->each(fn (RankItem $item) => DeleteRankItemManager::run($item));

        $name = DeleteRankName::run($name);

        return $name;
    }
}
