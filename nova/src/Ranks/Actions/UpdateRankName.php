<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Ranks\Data\RankNameData;
use Nova\Ranks\Models\RankName;

class UpdateRankName extends Action
{
    public function handle(RankName $name, RankNameData $data): RankName
    {
        return tap($name)
            ->update($data->toArray())
            ->refresh();
    }
}
