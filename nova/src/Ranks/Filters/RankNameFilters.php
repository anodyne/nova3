<?php

namespace Nova\Ranks\Filters;

use Nova\Foundation\Filters\Filters;

class RankNameFilters extends Filters
{
    protected $filters = ['search'];

    public function search($value)
    {
        return $this->builder->where('name', 'like', "%{$value}%");
    }
}
