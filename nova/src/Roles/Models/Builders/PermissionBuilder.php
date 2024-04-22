<?php

declare(strict_types=1);

namespace Nova\Roles\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class PermissionBuilder extends Builder
{
    public function searchFor($search): Builder
    {
        return $this->whereAny([
            'name',
            'display_name',
            'description',
        ], 'like', "%{$search}%");
    }
}
