<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Ranks\DataTransferObjects\RankNameData;
use Nova\Ranks\Models\RankName;

class CreateRankName
{
    use AsAction;

    public function handle(RankNameData $data): RankName
    {
        return RankName::create(array_merge(
            $data->toArray(),
            ['sort' => RankName::count()]
        ));
    }
}
