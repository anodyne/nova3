<?php

declare(strict_types=1);

namespace Nova\Foundation\Filters;

trait Filterable
{
    /**
     * Apply the filters.
     *
     *
     * @return Filters
     */
    public function filter(Filters $filters)
    {
        return $filters->apply($this);
    }
}
