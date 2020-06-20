<?php

namespace Nova\Ranks\Models\Builders;

use Nova\Foundation\Filters\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Nova\Ranks\Models\RankName;

class RankItemBuilder extends Builder
{
    use Filterable;

    public function withRankName()
    {
        return $this->addSelect(['rank_name' => RankName::select('name')
            ->whereColumn('id', 'rank_items.name_id')
            ->take(1)
        ]);
    }
}
