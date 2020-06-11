<?php

namespace Nova\Users\Filters;

use Nova\Users\Models\User;
use Nova\Foundation\Filters\Filters;

class UserFilters extends Filters
{
    protected $filters = ['search', 'status'];

    public function search($value)
    {
        return $this->builder->where('name', 'like', "%{$value}%")
            ->orWhere('email', 'like', "%{$value}%");
    }

    public function status($value)
    {
        return $this->builder->whereState(
            'status',
            User::getStatesFor('status')
                ->filter(function ($status) use ($value) {
                    return get_class_name($status) === ucfirst($value);
                })
                ->first()
        );
    }
}
