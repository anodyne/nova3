<?php

namespace Nova\Users\Filters;

use Nova\Foundation\Filters\Filters;

class UserFilters extends Filters
{
    protected $filters = ['search'];

    public function search($value)
    {
        return $this->builder->where('name', 'like', "%{$value}%")
            ->orWhere('email', 'like', "%{$value}%");
    }
}
