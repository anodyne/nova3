<?php

namespace Nova\Stories\Filters;

use Nova\Foundation\Filters\Filters;

class StoryFilters extends Filters
{
    protected $filters = ['search', 'sort'];

    public function search($value)
    {
        return $this->builder->where(function ($query) use ($value) {
            return $query->where('name', 'like', "%{$value}%")
                ->orWhere('key', 'like', "%{$value}%");
        });
    }

    public function sort($value)
    {
        if ($value === 'desc') {
            return $this->builder->defaultOrder();
        }

        return $this->builder->reorder()->reversed();
    }
}
