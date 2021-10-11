<?php

declare(strict_types=1);

namespace Nova\Notes\Filters;

use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Filters\Filters;

class NoteFilters extends Filters
{
    protected array $filters = ['search'];

    public function search($value): Builder
    {
        return $this->builder->where(fn ($query) => $query->searchFor($value));
    }
}
