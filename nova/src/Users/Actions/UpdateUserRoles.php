<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Foundation\Action;
use Nova\Users\Models\User;

class UpdateUserRoles extends Action
{
    use AsAction;

    public function handle(User $user, $roles): User
    {
        $user->syncRoles($roles);

        return $user->fresh();
    }
}
