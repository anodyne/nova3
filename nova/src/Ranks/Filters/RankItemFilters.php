<?php

declare(strict_types=1);

namespace Nova\Ranks\Filters;

use Nova\Foundation\Filters\Filters;

class RankItemFilters extends Filters
{
    protected $filters = ['group', 'search'];

    public function group($value)
    {
        return $this->builder->whereHas('group', function ($query) use ($value) {
            return $query->where('name', 'like', "%{$value}%");
        });
    }

    public function search($value)
    {
        return $this->builder->whereHas('name', function ($query) use ($value) {
            return $query->where('name', 'like', "%{$value}%");
        });
    }
}
