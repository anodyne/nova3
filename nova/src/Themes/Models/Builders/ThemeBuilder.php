<?php

namespace Nova\Themes\Models\Builders;

use Nova\Foundation\Filters\Filterable;
use Illuminate\Database\Eloquent\Builder;

class ThemeBuilder extends Builder
{
    use Filterable;

    public function whereActive(): Builder
    {
        return $this->where('active', true);
    }

    public function whereLocation($location): Builder
    {
        return $this->where('location', $location);
    }
}
