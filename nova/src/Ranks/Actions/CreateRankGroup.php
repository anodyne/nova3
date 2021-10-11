<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Ranks\DataTransferObjects\RankGroupData;
use Nova\Ranks\Models\RankGroup;

class CreateRankGroup
{
    use AsAction;

    public function handle(RankGroupData $data): RankGroup
    {
        return RankGroup::create(array_merge(
            $data->toArray(),
            ['sort' => RankGroup::count()]
        ));
    }
}
