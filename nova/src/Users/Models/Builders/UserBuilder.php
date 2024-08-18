<?php

declare(strict_types=1);

namespace Nova\Users\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Nova\Users\Models\States\Status\Active;
use Nova\Users\Models\States\Status\Hidden;
use Nova\Users\Models\States\Status\Inactive;
use Nova\Users\Models\States\Status\Pending;

class UserBuilder extends Builder
{
    public function countDistinct(): self
    {
        return $this->select(DB::raw('count(distinct(users.id))'));
    }

    public function searchFor(string $search): self
    {
        return $this
            ->where(fn (Builder $query): Builder => $query->whereAny(['users.name', 'users.email'], 'like', "%{$search}%"))
            ->orWhereRelation('characters', 'characters.name', 'like', "%{$search}%");
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
}
