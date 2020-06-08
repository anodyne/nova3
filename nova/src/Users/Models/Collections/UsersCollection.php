<?php

namespace Nova\Users\Models\Collections;

use Illuminate\Database\Eloquent\Collection;
use Nova\Users\Models\States\Active;

class UsersCollection extends Collection
{
    public function onlyActive()
    {
        return $this->filter(function ($user) {
            return $user->state->is(Active::class);
        });
    }
}
