<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Illuminate\Support\Facades\DB;
use Nova\Foundation\Actions\Action;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankName;

class DeleteRankNameManager extends Action
{
    public function handle(RankName $name): RankName
    {
        return DB::transaction(function () use ($name) {
            $name->loadMissing('ranks');

            $name->ranks->each(fn (RankItem $item): mixed => DeleteRankItemManager::run($item));

            return DeleteRankName::run($name);
        });
    }
}
