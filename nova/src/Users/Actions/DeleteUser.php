<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Nova\Users\Exceptions\CannotDeleteOwnAccountException;
use Nova\Users\Models\User;

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
