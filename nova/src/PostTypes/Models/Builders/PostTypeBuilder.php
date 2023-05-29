<?php

declare(strict_types=1);

namespace Nova\PostTypes\Models\Builders;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Nova\PostTypes\Enums\PostTypeStatus;

class PostTypeBuilder extends Builder
{
    public function searchFor($search): Builder
    {
        return $this->where('name', 'like', "%{$search}%");
    }

    public function whereActive(): Builder
    {
        return $this->where('status', PostTypeStatus::active);
    }

    public function whereUserHasAccess(Authenticatable $user): Builder
    {
        return $this->where(function ($query) use ($user) {
            return $query->whereNull('role_id')
                ->orWhereIn('role_id', $user->roles()->pluck('id')->all());
        });
    }
}
