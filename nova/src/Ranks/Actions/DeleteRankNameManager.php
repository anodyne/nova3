<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankName;

class DeleteRankNameManager
{
    use AsAction;

    public function handle(RankName $name): RankName
    {
        return DB::transaction(function () use ($name) {
            $name->loadMissing('ranks');

            $name->ranks->each(fn (RankItem $item) => DeleteRankItemManager::run($item));

            return DeleteRankName::run($name);
        });
    }
}
