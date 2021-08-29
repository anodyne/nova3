<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Users\Models\User;

class DeleteUserManager
{
    use AsAction;

    public function handle(User $user): User
    {
        DeleteUserCharacters::run($user);

        DeleteUser::run($user);

        return $user;
    }
}
