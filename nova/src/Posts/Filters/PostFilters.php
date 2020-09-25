<?php

namespace Nova\Posts\Filters;

use Nova\Foundation\Filters\Filters;

class PostFilters extends Filters
{
    protected $filters = ['search', 'sort'];

    public function search($value)
    {
        return $this->builder->where(function ($query) use ($value) {
            return $query->where('title', 'like', "%{$value}%")
                ->orWhere('day', 'like', "%{$value}%")
                ->orWhere('time', 'like', "%{$value}%")
                ->orWhere('location', 'like', "%{$value}%");
        });
    }

    public function sort($value)
    {
        if ($value === 'desc') {
            return $this->builder->defaultOrder();
        }

        if ($value === 'published') {
            return $this->builder->reorder()->orderByDesc('published_at');
        }

        return $this->builder->reorder()->reversed();
    }
}
