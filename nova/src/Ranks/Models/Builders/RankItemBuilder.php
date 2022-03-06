<?php

declare(strict_types=1);

namespace Nova\Ranks\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Filters\Filterable;
use Nova\Foundation\Models\Concerns\Sortable;
use Nova\Ranks\Models\RankName;

class RankItemBuilder extends Builder
{
    use Filterable;
    use Sortable;

    public function searchFor($value): self
    {
        return $this->whereHas(
            'name',
            fn ($query) => $query->where('name', 'like', "%{$value}%")
        );
    }

    public function orderBySort()
    {
        return $this->orderBy('group_id', 'asc')
            ->orderBy('sort', 'asc');
    }

    public function orderBySortDesc()
    {
        return $this->orderBy('group_id', 'desc')
            ->orderBy('sort', 'desc');
    }

    public function whereGroup($group)
    {
        return $this->where('group_id', $group);
    }

    public function whereName($name)
    {
        return $this->where('name_id', $name);
    }

    public function withRankName()
    {
        return $this->addSelect(['rank_name' => RankName::select('name')
            ->whereColumn('id', 'rank_items.name_id')
            ->take(1),
        ]);
    }
}
