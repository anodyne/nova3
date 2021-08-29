<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Ranks\Models\RankGroup;

class DeleteRankGroup
{
    use AsAction;

    public function handle(RankGroup $group): RankGroup
    {
        return tap($group)->delete();
    }
}
