<?php

namespace Nova\Themes\Models\Builders;

use Nova\Foundation\Filters\Filterable;
use Illuminate\Database\Eloquent\Builder;

class ThemeBuilder extends Builder
{
    use Filterable;

    /**
     * Scope the query to the location column.
     *
     * @param  string  $location
     *
     * @return Builder
     */
    public function whereLocation($location): Builder
    {
        return $this->where('location', '=', $location);
    }
}
