<?php

declare(strict_types=1);

namespace Nova\Roles\Filters;

use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Filters\Filters;

class RoleFilters extends Filters
{
    protected array $filters = ['search'];

    public function search($value): Builder
    {
        return $this->builder->where(function ($query) use ($value) {
            return $query->where('name', 'like', "%{$value}%")
                ->orWhere('display_name', 'like', "%{$value}%");
        });
    }
}
