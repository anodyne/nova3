<?php

namespace Nova\Roles\Models\Builders;

use Nova\Foundation\Filters\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Models\Concerns\Sortable;

class RoleBuilder extends Builder
{
    use Filterable;
    use Sortable;

    public function whereAtOrBelowSortOrder($maxSortValue): Builder
    {
        return $this->where('sort', '>=', $maxSortValue);
    }

    public function whereDefault(): Builder
    {
        return $this->where('default', true);
    }
}
