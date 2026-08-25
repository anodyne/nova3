<?php

declare(strict_types=1);

namespace Nova\Roles\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Roles\Models\Permission;

/**
 * @extends Builder<Permission>
 */
class PermissionBuilder extends Builder
{
    public function searchFor(string $search): self
    {
        return $this->whereAny([
            'name',
            'display_name',
            'description',
        ], 'like', "%{$search}%");
    }
}
