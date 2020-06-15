<?php

namespace Nova\Users\Models\Builders;

use Nova\Users\Models\Login;
use Nova\Users\Models\States\Active;
use Nova\Users\Models\States\Pending;
use Nova\Users\Models\States\Archived;
use Nova\Users\Models\States\Inactive;
use Nova\Foundation\Filters\Filterable;
use Illuminate\Database\Eloquent\Builder;

class UserBuilder extends Builder
{
    use Filterable;

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

    /**
     * Get the last login date.
     *
     * @return Builder
     */
    public function withLastLoginAt()
    {
        return $this->addSelect(['last_login_at' => Login::select('created_at')
            ->whereColumn('user_id', 'users.id')
            ->latest()
            ->take(1)
        ])->withCasts([
            'last_login_at' => 'date',
        ]);
    }
}
