<?php

namespace Nova\Ranks\Models\Builders;

use Nova\Foundation\Filters\Filterable;
use Illuminate\Database\Eloquent\Builder;

class RankGroupBuilder extends Builder
{
    use Filterable;

    public function orderBySort()
    {
        return $this->orderBy('sort', 'asc');
    }

    public function whereActive()
    {
        return $this->where('active', true);
    }
}
