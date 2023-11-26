<?php

declare(strict_types=1);

namespace Nova\Stories\Models\Builders;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Nova\Stories\Enums\PostTypeStatus;

class PostTypeBuilder extends Builder
{
    public function active(): Builder
    {
        return $this->where('status', PostTypeStatus::active);
    }

    public function inactive(): Builder
    {
        return $this->where('status', PostTypeStatus::inactive);
    }

    public function searchFor($search): Builder
    {
        return $this->where('name', 'like', "%{$search}%");
    }

    public function userHasAccess(Authenticatable $user): Builder
    {
        return $this->where(
            fn (Builder $query) => $query->whereNull('role_id')->orWhereIn('role_id', $user->roles()->pluck('id')->all())
        );
    }
}
