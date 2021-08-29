<?php

declare(strict_types=1);

namespace Nova\Ranks\Filters;

use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Filters\Filters;

class RankItemFilters extends Filters
{
    protected $filters = ['group', 'search'];

    public function group($value): Builder
    {
        return $this->builder->whereHas('group', function ($query) use ($value) {
            return $query->where('name', 'like', "%{$value}%");
        });
    }

    public function search($value): Builder
    {
        return $this->builder->whereHas('name', function ($query) use ($value) {
            return $query->where('name', 'like', "%{$value}%");
        });
    }
}
