<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Ranks\Models\RankName;

class ReorderRankNames
{
    use AsAction;

    public function handle(string $sort): void
    {
        collect(explode(',', $sort))->each(function ($id, $index) {
            RankName::where('id', $id)->update(['sort' => $index]);
        });
    }
}
