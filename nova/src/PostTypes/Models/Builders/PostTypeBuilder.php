<?php

declare(strict_types=1);

namespace Nova\PostTypes\Models\Builders;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Filters\Filterable;
use Nova\Foundation\Models\Concerns\Sortable;
use Nova\PostTypes\Models\States\Active;

class PostTypeBuilder extends Builder
{
    use Filterable;
    use Sortable;

    public function searchFor($search): Builder
    {
        return $this->where('name', 'like', "%{$search}%");
    }

    public function whereActive(): Builder
    {
        return $this->whereState('status', Active::class);
    }

    public function whereUserHasAccess(Authenticatable $user): Builder
    {
        return $this->where(function ($query) use ($user) {
            return $query->whereNull('role_id')
                ->orWhereIn('role_id', $user->roles()->pluck('id')->all());
        });
    }
}
