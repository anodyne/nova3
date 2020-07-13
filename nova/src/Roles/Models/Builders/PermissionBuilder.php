<?php

namespace Nova\Roles\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class PermissionBuilder extends Builder
{
    public function filter(array $filters): Builder
    {
        return $this->when($filters['search'] ?? null, function ($query, $search) {
            return $query->where(function ($q) use ($search) {
                return $q->where('name', 'like', "%{$search}%")
                    ->orWhere('display_name', 'like', "%{$search}%");
            });
        });
    }
}
