<?php

namespace Nova\Ranks\Actions;

use Nova\Ranks\Models\RankName;

class DuplicateRankName
{
    public function execute(RankName $originalName): RankName
    {
        $name = $originalName->replicate();

        $name->name = "Copy of {$originalName->name}";

        $name->save();

        return $name->refresh();
    }
}
