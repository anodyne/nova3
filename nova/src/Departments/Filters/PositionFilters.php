<?php

declare(strict_types=1);

namespace Nova\Departments\Filters;

use Nova\Foundation\Filters\Filters;

class PositionFilters extends Filters
{
    protected $filters = ['search'];

    public function search($value)
    {
        return $this->builder->where('name', 'like', "%{$value}%");
    }
}
