<?php

declare(strict_types=1);

namespace Nova\Forms\Filters;

use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Filters\Filters;

class FormFilters extends Filters
{
    protected array $filters = ['search'];

    public function search($value): Builder
    {
        return $this->builder->where(fn ($query) => $query->searchFor($value));
    }
}
