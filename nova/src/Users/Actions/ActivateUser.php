<?php

namespace Nova\Users\Actions;

use Nova\Users\Models\User;
use Nova\Users\Models\States\Active;

class ActivateUser
{
    public function execute(User $user): User
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->log(':subject.name was activated');

        $user->status->transitionTo(Active::class);

        return $user->refresh();
    }
}
