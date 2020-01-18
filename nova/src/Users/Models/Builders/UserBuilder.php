<?php

namespace Nova\Users\Models\Builders;

use Nova\Users\Models\States\Active;
use Nova\Users\Models\States\Pending;
use Nova\Users\Models\States\Archived;
use Nova\Users\Models\States\Inactive;
use Illuminate\Database\Eloquent\Builder;

class UserBuilder extends Builder
{
    public function filter(array $filters)
    {
        return $this->when($filters['search'] ?? null, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        });
    }

    /**
     * Get active users.
     *
     * @return Builder
     */
    public function whereActive()
    {
        return $this->where('state', '=', Active::class);
    }

    /**
     * Get archived users.
     *
     * @return Builder
     */
    public function whereArchived()
    {
        return $this->where('state', '=', Archived::class);
    }

    /**
     * Get inactive users.
     *
     * @return Builder
     */
    public function whereInactive()
    {
        return $this->where('state', '=', Inactive::class);
    }

    /**
     * Get pending users.
     *
     * @return Builder
     */
    public function wherePending()
    {
        return $this->where('state', '=', Pending::class);
    }
}
