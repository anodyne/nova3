<?php

declare(strict_types=1);

namespace Nova\Ranks\Filters;

use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Filters\Filters;

class RankGroupFilters extends Filters
{
    protected $filters = ['search'];

    public function search($value): Builder
    {
        return $this->builder->where('name', 'like', "%{$value}%");
    }
}
