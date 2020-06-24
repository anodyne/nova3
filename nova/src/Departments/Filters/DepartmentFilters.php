<?php

namespace Nova\Departments\Filters;

use Nova\Foundation\Filters\Filters;

class DepartmentFilters extends Filters
{
    protected $filters = ['search'];

    public function search($value)
    {
        return $this->builder->where('name', 'like', "%{$value}%");
    }
}
