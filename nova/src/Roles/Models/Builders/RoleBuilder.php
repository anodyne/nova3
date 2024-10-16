<?php

declare(strict_types=1);

namespace Nova\Roles\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class RoleBuilder extends Builder
{
    public function atOrAboveOrderColumn($maxSortValue): Builder
    {
        return $this->where('order_column', '<=', $maxSortValue);
    }

    public function atOrBelowOrderColumn($maxSortValue): Builder
    {
        return $this->where('order_column', '>=', $maxSortValue);
    }

    public function isDefault(): Builder
    {
        return $this->where('is_default', true);
    }

    public function searchFor($search): Builder
    {
        return $this->whereAny([
            'name',
            'display_name',
            'description',
        ], 'like', "%{$search}%");
    }
}
