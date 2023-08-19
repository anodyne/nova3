<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Models\RankItem;

class DeleteRankGroup
{
    use AsAction;

    public function handle(RankGroup $group): RankGroup
    {
        $group->ranks->each(fn (RankItem $item) => DeleteRankItem::run($item));

        return tap($group)->delete();
    }
}
