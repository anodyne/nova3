<?php

declare(strict_types=1);

namespace Nova\Users\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Characters\Models\Character;
use Nova\Foundation\Models\Builders\Concerns\ActiveBetween;
use Nova\Users\Models\States\Status\Active;
use Nova\Users\Models\States\Status\Hidden;
use Nova\Users\Models\States\Status\Inactive;
use Nova\Users\Models\States\Status\Pending;
use Nova\Users\Models\User;

class UserBuilder extends Builder
{
    use ActiveBetween;

    public function countDistinct(): self
    {
        return $this->selectRaw('count(distinct(users.id))');
    }

    public function searchFor(string $search): self
    {
        return $this
            ->where(fn (Builder $query): Builder => $query->whereAny([User::column('name'), User::column('email')], 'like', "%{$search}%"))
            ->orWhereRelation('characters', Character::column('name'), 'like', "%{$search}%");
    }

    public function searchForBasic($search): self
    {
        return $this->where('name', 'like', "%{$search}%");
    }

    public function searchForWithoutCharacters(string $search): self
    {
        return $this->whereAny(['name', 'email'], 'like', "%{$search}%");
    }

    public function active(): self
    {
        return $this->whereState('status', Active::class);
    }

    public function activeOrInactive(): self
    {
        return $this->where(function (Builder $query): Builder {
            return $query->whereState('status', Active::class)
                ->orWhereState('status', Inactive::class);
        });
    }

    public function hidden(): Builder
    {
        return $this->whereState('status', Hidden::class);
    }

    public function notHidden(): Builder
    {
        return $this->whereNotState('status', Hidden::class);
    }

    public function inactive(): self
    {
        return $this->whereState('status', Inactive::class);
    }

    public function pending(): self
    {
        return $this->whereState('status', Pending::class);
    }

    public function notPending(): self
    {
        return $this->whereNotState('status', Pending::class);
    }

    public function selectTotalCount(): self
    {
        return $this->selectRaw('COUNT(*) as total_count');
    }
}
