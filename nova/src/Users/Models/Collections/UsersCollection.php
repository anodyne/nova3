<?php

namespace Nova\Users\Models\Collections;

use Nova\Users\Models\States\Active;
use Illuminate\Database\Eloquent\Collection;

class UsersCollection extends Collection
{
    public function onlyActive()
    {
        return $this->filter(function ($user) {
            return $user->status->is(Active::class);
        });
    }
}
