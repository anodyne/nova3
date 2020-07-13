<?php

namespace Nova\Stories\Filters;

use Nova\Foundation\Filters\Filters;

class PostTypeFilters extends Filters
{
    protected $filters = ['search'];

    public function search($value)
    {
        return $this->builder->where('name', 'like', "%{$value}%");
    }
}
