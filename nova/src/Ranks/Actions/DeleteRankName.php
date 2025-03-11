<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Ranks\Models\RankName;

class DeleteRankName
{
    use AsAction;

    public function handle(RankName $name): RankName
    {
        return tap($name)->delete();
    }
}
