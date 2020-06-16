<?php

namespace Nova\Notes\Filters;

use Nova\Foundation\Filters\Filters;

class NoteFilters extends Filters
{
    protected $filters = ['search'];

    public function search($value)
    {
        return $this->builder
            ->where('title', 'like', "%{$value}%")
            ->orWhere('content', 'like', "%{$value}%")
            ->orWhere('summary', 'like', "%{$value}%");
    }
}
