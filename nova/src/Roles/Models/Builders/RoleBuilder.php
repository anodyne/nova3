<?php

declare(strict_types=1);

namespace Nova\Roles\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class RoleBuilder extends Builder
{
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
