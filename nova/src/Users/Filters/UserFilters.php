<?php

declare(strict_types=1);

namespace Nova\Users\Filters;

use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Filters\Filters;

class UserFilters extends Filters
{
    protected array $filters = ['search', 'status'];

    public function search($value): Builder
    {
        return $this->builder->searchFor($value);
    }

    public function status($value): Builder
    {
        return $this->builder->whereState('status', $value);
    }
}
