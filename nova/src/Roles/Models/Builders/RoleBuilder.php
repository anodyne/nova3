<?php

declare(strict_types=1);

namespace Nova\Roles\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Filters\Filterable;
use Nova\Foundation\Models\Concerns\Sortable;

class RoleBuilder extends Builder
{
    use Filterable;
    use Sortable;

    public function searchFor($search): Builder
    {
        return $this->where(function ($query) use ($search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('display_name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        });
    }

    public function whereAtOrBelowSortOrder($maxSortValue): Builder
    {
        return $this->where('sort', '>=', $maxSortValue);
    }

    public function whereDefault(): Builder
    {
        return $this->where('default', true);
    }
}
