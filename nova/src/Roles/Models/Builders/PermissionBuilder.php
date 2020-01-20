<?php

namespace Nova\Roles\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class PermissionBuilder extends Builder
{
    public function filter(array $filters)
    {
        return $this->when($filters['search'] ?? null, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('display_name', 'like', "%{$search}%");
        });
    }
}
