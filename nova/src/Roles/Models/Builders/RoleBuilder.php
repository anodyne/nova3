<?php

declare(strict_types=1);

namespace Nova\Roles\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class RoleBuilder extends Builder
{
    public function atOrBelowOrderColumn($maxSortValue): Builder
    {
        return $this->where('order_column', '>=', $maxSortValue);
    }

    public function default(): Builder
    {
        return $this->where('default', true);
    }

    public function searchFor($search): Builder
    {
        return $this->where(function ($query) use ($search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('display_name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        });
    }
}
