<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Users\Exceptions\UserException;
use Nova\Users\Models\User;

class DeleteUser
{
    use AsAction;

    public function handle(User $user): User
    {
        throw_if(
            $user->is(auth()->user()),
            UserException::cannotDeleteOwnAccount()
        );

        return tap($user)->delete();
    }
}
