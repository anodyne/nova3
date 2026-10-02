<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Ranks\Models\RankName;

class DeleteRankName extends Action
{
    public function handle(RankName $name): RankName
    {
        return tap($name)->delete();
    }
}
