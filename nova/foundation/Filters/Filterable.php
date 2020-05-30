<?php

namespace Nova\Foundation\Filters;

trait Filterable
{
    /**
     * Apply the filters.
     *
     * @param  Filters  $filters
     *
     * @return Filters
     */
    public function filter(Filters $filters)
    {
        return $filters->apply($this);
    }
}
