<?php

declare(strict_types=1);

namespace Nova\Themes\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Filters\Filterable;

class ThemeBuilder extends Builder
{
    use Filterable;

    public function active(): Builder
    {
        return $this->where('active', true);
    }

    public function whereLocation($location): Builder
    {
        return $this->where('location', $location);
    }
}
