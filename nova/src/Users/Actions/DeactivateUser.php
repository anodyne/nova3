<?php

namespace Nova\Users\Actions;

use Nova\Users\Models\User;
use Nova\Users\Models\States\Inactive;

class DeactivateUser
{
    public function execute(User $user): User
    {
        $user->status->transitionTo(Inactive::class);

        return $user->refresh();
    }
}
