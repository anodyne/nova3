<?php

declare(strict_types=1);

namespace Nova\Roles\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Roles\Models\Permission;

/**
 * @template TModel of Permission
 *
 * @extends Builder<TModel>
 */
class PermissionBuilder extends Builder
{
    public function searchFor($search): self
    {
        return $this->whereAny([
            'name',
            'display_name',
            'description',
        ], 'like', "%{$search}%");
    }
}
