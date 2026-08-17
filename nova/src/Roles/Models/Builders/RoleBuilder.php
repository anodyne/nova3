<?php

declare(strict_types=1);

namespace Nova\Roles\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Roles\Models\Role;

/**
 * @template TModel of Role
 *
 * @extends Builder<TModel>
 */
class RoleBuilder extends Builder
{
    public function atOrAboveOrderColumn($maxSortValue): self
    {
        return $this->where('order_column', '<=', $maxSortValue);
    }

    public function atOrBelowOrderColumn($maxSortValue): self
    {
        return $this->where('order_column', '>=', $maxSortValue);
    }

    public function isDefault(): self
    {
        return $this->where('is_default', true);
    }

    public function searchFor($search): self
    {
        return $this->whereAny([
            'name',
            'display_name',
            'description',
        ], 'like', "%{$search}%");
    }
}
