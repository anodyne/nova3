<?php

declare(strict_types=1);

namespace Nova\Characters\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Models\States\Status\Active;
use Nova\Characters\Models\States\Status\Inactive;
use Nova\Characters\Models\States\Status\Pending;
use Nova\Users\Models\User;

class CharacterBuilder extends Builder
{
    public function isAssignedTo(User $user): self
    {
        return $this->whereRelation('users', 'users.id', '=', $user->id);
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

    public function searchForBasic($search): self
    {
        return $this->where('name', 'like', "%{$search}%");
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

    public function active(): Builder
    {
        return $this->whereState('status', Active::class);
    }

    public function inactive(): Builder
    {
        return $this->whereState('status', Inactive::class);
    }

    public function whereIsPrimaryCharacter(): Builder
    {
        return $this->join('character_user', 'character_user.character_id', '=', 'characters.id')
            ->where('character_user.primary', true);
    }

    public function pending(): Builder
    {
        return $this->whereState('status', Pending::class);
    }

    public function notPending(): Builder
    {
        return $this->whereNotState('status', Pending::class);
    }

    public function primary(): Builder
    {
        return $this->where('type', CharacterType::primary);
    }

    public function notPrimary(): Builder
    {
        return $this->where('type', '!=', CharacterType::primary);
    }

    public function secondary(): Builder
    {
        return $this->where('type', CharacterType::secondary);
    }

    public function notSecondary(): Builder
    {
        return $this->where('type', '!=', CharacterType::secondary);
    }

    public function support(): Builder
    {
        return $this->where('type', CharacterType::support);
    }

    public function notSupport(): Builder
    {
        return $this->where('type', '!=', CharacterType::support);
    }
}
