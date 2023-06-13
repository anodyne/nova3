<?php

declare(strict_types=1);

namespace Nova\Ranks\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Ranks\Models\RankName;

class DuplicateRankName
{
    use AsAction;

    public function handle(RankName $original): RankName
    {
        $name = $original->replicate();
        $name->name = "Copy of {$original->name}";
        $name->save();

        return $name->refresh();
    }
}
