<?php

declare(strict_types=1);

namespace Nova\PostTypes\Filters;

use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Filters\Filters;

class PostTypeFilters extends Filters
{
    protected $filters = ['search'];

    public function search($value): Builder
    {
        return $this->builder->where('name', 'like', "%{$value}%");
    }
}
