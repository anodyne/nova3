<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Users\Models\User;

class SetUserRoles
{
    use AsAction;

    public function handle(User $user, $roles): User
    {
        $user->syncRoles($roles);

        return $user->refresh();
    }
}
