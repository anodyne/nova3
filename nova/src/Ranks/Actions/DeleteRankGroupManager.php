<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Illuminate\Support\Facades\DB;
use Nova\Foundation\Actions\Action;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Models\RankItem;

class DeleteRankGroupManager extends Action
{
    public function handle(RankGroup $group): RankGroup
    {
        return DB::transaction(function () use ($group) {
            $group->ranks->each(fn (RankItem $item): mixed => DeleteRankItemManager::run($item));

            return DeleteRankGroup::run($group);
        });
    }
}
