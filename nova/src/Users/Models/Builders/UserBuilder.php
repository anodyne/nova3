<?php

declare(strict_types=1);

namespace Nova\Users\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Filters\Filterable;
use Nova\Users\Models\States\Active;
use Nova\Users\Models\States\Archived;
use Nova\Users\Models\States\Inactive;
use Nova\Users\Models\States\Pending;

class UserBuilder extends Builder
{
    use Filterable;

    public function searchFor(string $search): self
    {
        return $this->where(function ($query) use ($search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })
            ->orWhereHas('characters', function ($query) use ($search) {
                return $query->where('name', 'like', "%{$search}%");
            });
    }

    public function searchForWithoutCharacters(string $search): self
    {
        return $this->where(
            fn (self $query) => $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
        );
    }

    public function whereActive(): self
    {
        return $this->whereState('status', Active::class);
    }

    public function whereArchived(): self
    {
        return $this->whereState('status', Archived::class);
    }

    public function whereInactive(): self
    {
        return $this->whereState('status', Inactive::class);
    }

    public function wherePending(): self
    {
        return $this->whereState('status', Pending::class);
    }

    public function whereNotPending(): self
    {
        return $this->whereNotState('status', Pending::class);
    }
}
