<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Users\Models\User;

class ActivateUserManager
{
    use AsAction;

    public function handle(Request $request, User $user): User
    {
        $user = ActivateUser::run($user);

        if ((bool) $request->activate_primary_character) {
            ActivateUserPreviousCharacter::run($user);
        }

        return $user;
    }
}
