<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Ranks\Data\RankNameData;
use Nova\Ranks\Models\RankName;

class CreateRankName extends Action
{
    public function handle(RankNameData $data): RankName
    {
        return RankName::create($data->toArray());
    }
}
