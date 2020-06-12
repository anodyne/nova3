<?php

namespace Nova\Roles\Filters;

use Nova\Foundation\Filters\Filters;

class RoleFilters extends Filters
{
    protected $filters = ['search'];

    public function search($value)
    {
        return $this->builder->where('name', 'like', "%{$value}%")
            ->orWhere('display_name', 'like', "%{$value}%");
    }
}
