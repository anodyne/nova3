<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Nova\Ranks\Models\RankName;

class DeleteRankName
{
    public function execute(RankName $name): RankName
    {
        return tap($name)->delete();
    }
}
