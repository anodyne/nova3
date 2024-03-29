<?php

declare(strict_types=1);

namespace Nova\Users\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Nova\Users\Models\States\Status\Active;
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
        return $this->where(function ($query) use ($search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })
            ->orWhereHas('characters', function ($query) use ($search) {
                return $query->where('name', 'like', "%{$search}%");
            });
    }

    public function searchForBasic($search): self
    {
        return $this->where('name', 'like', "%{$search}%");
    }

    public function searchForWithoutCharacters(string $search): self
    {
        return $this->where(
            fn (self $query) => $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
        );
    }

    public function active(): self
    {
        return $this->whereState('status', Active::class);
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
