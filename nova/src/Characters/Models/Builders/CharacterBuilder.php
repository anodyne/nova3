<?php

declare(strict_types=1);

namespace Nova\Characters\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Models\States\Status\Active;
use Nova\Characters\Models\States\Status\Hidden;
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
        return $this->where(fn (Builder $query): Builder => $query->where('name', 'like', "%{$search}%"))
            ->orWhereRelation('positions', 'positions.name', 'like', "%{$search}%")
            ->orWhereRelation('positions.department', 'departments.name', 'like', "%{$search}%")
            ->orWhereRelation('users', 'users.name', 'like', "%{$search}%")
            ->when(
                Auth::user()->isAbleTo('character.*'),
                fn (Builder $query): Builder => $query->orWhereRelation('users', 'users.email', 'like', "%{$search}%")
            );
    }

    public function searchForBasic($search): self
    {
        return $this->where('name', 'like', "%{$search}%");
    }

    public function searchForWithoutUsers($search): Builder
    {
        return $this->where(fn (Builder $query): Builder => $query->where('name', 'like', "%{$search}%"))
            ->orWhereRelation('positions', 'positions.name', 'like', "%{$search}%")
            ->orWhereRelation('positions.department', 'departments.name', 'like', "%{$search}%");
    }

    public function active(): Builder
    {
        return $this->whereState('status', Active::class);
    }

    public function hidden(): Builder
    {
        return $this->whereState('status', Hidden::class);
    }

    public function notHidden(): Builder
    {
        return $this->whereNotState('status', Hidden::class);
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
