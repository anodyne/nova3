<?php

namespace Nova\Ranks\Models\Builders;

use Nova\Ranks\Models\RankName;
use Nova\Foundation\Filters\Filterable;
use Illuminate\Database\Eloquent\Builder;

class RankItemBuilder extends Builder
{
    use Filterable;

    public function orderBySort()
    {
        return $this->orderBy('sort', 'asc');
    }

    public function withRankName()
    {
        return $this->addSelect(['rank_name' => RankName::select('name')
            ->whereColumn('id', 'rank_items.name_id')
            ->take(1),
        ]);
    }
}
