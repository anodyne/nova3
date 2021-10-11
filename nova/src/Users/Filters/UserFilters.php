<?php

declare(strict_types=1);

namespace Nova\Users\Filters;

use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Filters\Filters;
use Nova\Users\Models\User;

class UserFilters extends Filters
{
    protected array $filters = ['search', 'status'];

    public function search($value): Builder
    {
        return $this->builder->searchFor($value);
    }

    public function status($value): Builder
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
