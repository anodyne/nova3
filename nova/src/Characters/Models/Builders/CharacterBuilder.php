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
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Foundation\Models\Builders\Concerns\ActiveBetween;
use Nova\Users\Models\User;

class CharacterBuilder extends Builder
{
    use ActiveBetween;

    public function isAssignedTo(User $user): self
    {
        return $this->whereRelation('users', User::column('id'), '=', $user->id);
    }

    public function searchFor($search): Builder
    {
        return $this->where(fn (Builder $query): Builder => $query->where('name', 'like', "%{$search}%"))
            ->orWhereRelation('positions', Position::column('name'), 'like', "%{$search}%")
            ->orWhereRelation('positions.department', Department::column('name'), 'like', "%{$search}%")
            ->orWhereRelation('users', User::column('name'), 'like', "%{$search}%")
            ->when(
                Auth::user()->isAbleTo('character.*'),
                fn (Builder $query): Builder => $query->orWhereRelation('users', User::column('email'), 'like', "%{$search}%")
            );
    }

    public function searchForBasic($search): self
    {
        return $this->where('name', 'like', "%{$search}%");
    }

    public function searchForWithoutUsers($search): Builder
    {
        return $this->where(fn (Builder $query): Builder => $query->where('name', 'like', "%{$search}%"))
            ->orWhereRelation('positions', Position::column('name'), 'like', "%{$search}%")
            ->orWhereRelation('positions.department', Department::column('name'), 'like', "%{$search}%");
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
        return $this->where('type', CharacterType::Primary);
    }

    public function notPrimary(): Builder
    {
        return $this->where('type', '!=', CharacterType::Primary);
    }

    public function secondary(): Builder
    {
        return $this->where('type', CharacterType::Secondary);
    }

    public function notSecondary(): Builder
    {
        return $this->where('type', '!=', CharacterType::Secondary);
    }

    public function support(): Builder
    {
        return $this->where('type', CharacterType::Support);
    }

    public function notSupport(): Builder
    {
        return $this->where('type', '!=', CharacterType::Support);
    }

    public function selectTotalCount(): self
    {
        return $this->selectRaw('COUNT(*) as total_count');
    }

    public function selectTypeCounts(): self
    {
        return $this
            ->selectRaw("
                SUM(CASE WHEN type = 'primary' THEN 1 ELSE 0 END) as primary_count,
                SUM(CASE WHEN type = 'secondary' THEN 1 ELSE 0 END) as secondary_count,
                SUM(CASE WHEN type = 'support' THEN 1 ELSE 0 END) as support_count
            ");
    }
}
