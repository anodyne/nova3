<?php

declare(strict_types=1);

namespace Nova\Users\Filters;

use Nova\Foundation\Filters\Filters;
use Nova\Users\Models\User;

class UserFilters extends Filters
{
    protected $filters = ['search', 'status'];

    public function search($value)
    {
        return $this->builder
            ->where(function ($query) use ($value) {
                return $query->where('name', 'like', "%{$value}%")
                    ->orWhere('email', 'like', "%{$value}%");
            })
            ->orWhereHas('characters', function ($query) use ($value) {
                return $query->where('name', 'like', "%{$value}%");
            });
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
