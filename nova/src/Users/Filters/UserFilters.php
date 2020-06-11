<?php

namespace Nova\Users\Filters;

use Nova\Foundation\Filters\Filters;
use Nova\Users\Models\User;

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
        $status = User::getStatesFor('status')
            ->filter(function ($status) use ($value) {
                return collect(explode('\\', $status))->last() === ucfirst($value);
            })
            ->first();

        return $this->builder->whereState('status', $status);
    }
}
