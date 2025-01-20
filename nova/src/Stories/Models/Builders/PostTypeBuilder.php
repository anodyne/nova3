<?php

declare(strict_types=1);

namespace Nova\Stories\Models\Builders;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Nova\Stories\Enums\PostTypeStatus;
use Nova\Stories\Enums\PostTypeVisibility;

class PostTypeBuilder extends Builder
{
    public function active(): Builder
    {
        return $this->where('status', PostTypeStatus::Active);
    }

    public function inactive(): Builder
    {
        return $this->where('status', PostTypeStatus::Inactive);
    }

    public function inCharacter(): Builder
    {
        return $this->where('visibility', PostTypeVisibility::InCharacter);
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
