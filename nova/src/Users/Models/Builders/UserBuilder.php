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

    /**
     * Get active users.
     *
     * @return Builder
     */
    public function whereActive()
    {
        return $this->where('status', '=', Active::class);
    }

    /**
     * Get archived users.
     *
     * @return Builder
     */
    public function whereArchived()
    {
        return $this->where('status', '=', Archived::class);
    }

    /**
     * Get inactive users.
     *
     * @return Builder
     */
    public function whereInactive()
    {
        return $this->where('status', '=', Inactive::class);
    }

    /**
     * Get pending users.
     *
     * @return Builder
     */
    public function wherePending()
    {
        return $this->where('status', '=', Pending::class);
    }
}
