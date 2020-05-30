<?php

namespace Nova\Themes\Filters;

use Nova\Foundation\Filters\Filters;
use Illuminate\Database\Eloquent\Builder;

class ThemeFilters extends Filters
{
    /**
     * @var array
     */
    protected $filters = ['search'];

    /**
     * Filter the query according to those that are unanswered.
     *
     * @param  string  $search
     *
     * @return Builder
     */
    protected function search($search): Builder
    {
        return $this->builder->where('name', 'like', "%{$search}%")
            ->orWhere('location', 'like', "%{$search}%");
    }
}
