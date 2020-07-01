<?php

namespace Nova\Characters\Models\Builders;

use Nova\Foundation\Filters\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Nova\Characters\Models\States\Active;
use Nova\Characters\Models\States\Pending;
use Nova\Characters\Models\States\Inactive;

class CharacterBuilder extends Builder
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

    public function whereIsPrimaryCharacter()
    {
        return $this->join('character_user', 'character_user.character_id', '=', 'characters.id')
            ->where('character_user.primary', true);
    }

    public function whereHasUser()
    {
        return $this->whereHas('user');
    }

    public function whereDoesntHaveUser()
    {
        return $this->whereDoesntHave('user');
    }
}
