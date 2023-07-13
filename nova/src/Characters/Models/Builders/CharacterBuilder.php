<?php

declare(strict_types=1);

namespace Nova\Characters\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Characters\Models\States\Status\Active;
use Nova\Characters\Models\States\Status\Inactive;
use Nova\Characters\Models\States\Status\Pending;
use Nova\Users\Models\User;

class CharacterBuilder extends Builder
{
    public function isAssignedTo(User $user): Builder
    {
        return $this->whereHas(
            'users',
            fn ($query) => $query->whereRelation('users', 'users.id', '=', $user->id)
        );
    }

    public function searchForWithoutUsers($search): Builder
    {
        return $this->where(fn ($q) => $q->where('name', 'like', "%{$search}%"))
            ->orWhereHas('positions', fn ($q) => $q->where('name', 'like', "%{$search}%"))
            ->orWhereHas('positions.department', fn ($q) => $q->where('name', 'like', "%{$search}%"))
            ->when(auth()->user()->isAbleTo('character.*'), function ($query) use ($search) {
                return $query->orWhereHas('users', fn ($q) => $q->where('email', 'like', "%{$search}%"));
            });
    }

    public function searchFor($search): Builder
    {
        return $this->where(fn ($q) => $q->where('name', 'like', "%{$search}%"))
            ->orWhereHas('positions', fn ($q) => $q->where('name', 'like', "%{$search}%"))
            ->orWhereHas('positions.department', fn ($q) => $q->where('name', 'like', "%{$search}%"))
            ->orWhereHas('users', fn ($q) => $q->where('name', 'like', "%{$search}%"))
            ->when(auth()->user()->isAbleTo('character.*'), function ($query) use ($search) {
                return $query->orWhereHas('users', fn ($q) => $q->where('email', 'like', "%{$search}%"));
            });
    }

    public function active(): Builder
    {
        return $this->whereState('status', Active::class);
    }

    public function whereInactive(): Builder
    {
        return $this->whereState('status', Inactive::class);
    }

    public function whereIsPrimaryCharacter(): Builder
    {
        return $this->join('character_user', 'character_user.character_id', '=', 'characters.id')
            ->where('character_user.primary', true);
    }

    public function wherePending(): Builder
    {
        return $this->whereState('status', Pending::class);
    }

    public function whereNotPending(): Builder
    {
        return $this->whereNotState('status', Pending::class);
    }
}
