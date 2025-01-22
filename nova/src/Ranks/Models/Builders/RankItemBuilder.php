<?php

declare(strict_types=1);

namespace Nova\Ranks\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Models\Builders\Concerns\QueriesStatus;
use Nova\Ranks\Models\RankName;

class RankItemBuilder extends Builder
{
    use QueriesStatus;

    public function group($group)
    {
        return $this->where('group_id', $group);
    }

    public function name($name)
    {
        return $this->where('name_id', $name);
    }

    public function searchFor($search): self
    {
        return $this->whereRelation('name', 'name', 'like', "%{$search}%");
    }

    public function withRankName()
    {
        return $this->addSelect(['rank_name' => RankName::select('name')
            ->whereColumn('id', 'rank_items.name_id')
            ->take(1),
        ]);
    }
}
