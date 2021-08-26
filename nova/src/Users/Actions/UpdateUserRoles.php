<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Nova\Foundation\Action;
use Nova\Users\Models\User;

class UpdateUserRoles extends Action
{
    public function execute(User $user, $roles): User
    {
        $user->syncRoles($roles);

        return $user->fresh();
    }
}
