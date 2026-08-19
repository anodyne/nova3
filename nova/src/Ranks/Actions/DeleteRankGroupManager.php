<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Models\RankItem;

class DeleteRankGroupManager
{
    use AsAction;

    public function handle(RankGroup $group): RankGroup
    {
        return DB::transaction(function () use ($group) {
            $group->ranks->each(fn (RankItem $item): mixed => DeleteRankItemManager::run($item));

            return DeleteRankGroup::run($group);
        });
    }
}
