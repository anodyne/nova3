<?php

namespace Nova\Users\Actions;

use Nova\Users\Models\User;
use Nova\Users\Models\States\Inactive;

class DeactivateUser
{
    public function execute(User $user): User
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->log(':subject.name was activated');

        $user->status->transitionTo(Inactive::class);

        return $user->refresh();
    }
}
