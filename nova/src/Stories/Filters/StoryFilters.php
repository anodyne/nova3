<?php

declare(strict_types=1);

namespace Nova\Stories\Filters;

use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Filters\Filters;

class StoryFilters extends Filters
{
    protected array $filters = ['search', 'sort'];

    public function search($value): Builder
    {
        return $this->builder->where(function ($query) use ($value) {
            return $query->where('name', 'like', "%{$value}%")
                ->orWhere('key', 'like', "%{$value}%");
        });
    }

    public function sort($value): Builder
    {
        if ($value === 'desc') {
            return $this->builder->defaultOrder();
        }

        return $this->builder->reorder()->reversed();
    }
}
