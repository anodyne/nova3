<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Ranks\Data\RankNameData;
use Nova\Ranks\Models\RankName;

class UpdateRankName
{
    use AsAction;

    public function handle(RankName $name, RankNameData $data): RankName
    {
        return tap($name)
            ->update($data->all())
            ->refresh();
    }
}
