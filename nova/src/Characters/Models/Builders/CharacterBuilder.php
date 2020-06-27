<?php

namespace Nova\Characters\Models\Builders;

use Nova\Users\Models\User;
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

    /**
     * Get the assigned user.
     *
     * @return Builder
     */
    public function withAssignedUser()
    {
        // return $this->whereHas('user', function ($query) {
        //     return $query->join('user_character', 'user_character.character_id', '=', 'characters.id')
        //         ->addSelect([
        //             'assigned_user' => User::select('name')
        //                 ->whereColumn('user_character.user_id', 'users.id')
        //                 ->latest()
        //                 ->take(1),
        //         ]);
        // });

        return $this->join('user_character', 'user_character.character_id', '=', 'characters.id')
            ->addSelect(['assigned_user' => User::select('name')
            ->whereColumn('user_character.user_id', 'users.id')
            ->latest()
            ->take(1),
            ]);
    }
}
