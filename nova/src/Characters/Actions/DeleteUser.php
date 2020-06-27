<?php

namespace Nova\Users\Actions;

use Nova\Users\Models\User;
use Nova\Users\Exceptions\CannotDeleteOwnAccountException;

class DeleteUser
{
    public function execute(User $user): User
    {
        if ($user->is(auth()->user())) {
            throw new CannotDeleteOwnAccountException('You cannot delete your own account.');
        }

        return tap($user)->delete();
    }
}
