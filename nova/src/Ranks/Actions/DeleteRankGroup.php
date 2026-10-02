<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Ranks\Models\RankGroup;

class DeleteRankGroup extends Action
{
    public function handle(RankGroup $group): RankGroup
    {
        return tap($group)->delete();
    }
}
