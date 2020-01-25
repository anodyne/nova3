<?php

namespace Nova\Themes\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class ThemeBuilder extends Builder
{
    public function filter(array $filters)
    {
        return $this->when($filters['search'] ?? null, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('location', 'like', "%{$search}%");
        });
    }

    /**
     * Scope the query to the location column.
     *
     * @param  string  $location
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function whereLocation($location)
    {
        return $this->where('location', '=', $location);
    }
}
