<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Illuminate\Http\Request;
use Nova\Users\Models\User;

class ActivateUserManager
{
    protected $activateUser;

    protected $activateUserPreviousCharacter;

    public function __construct(
        ActivateUser $activateUser,
        ActivateUserPreviousCharacter $activateUserPreviousCharacter
    ) {
        $this->activateUser = $activateUser;
        $this->activateUserPreviousCharacter = $activateUserPreviousCharacter;
    }

    public function execute(Request $request, User $user): User
    {
        $user = $this->activateUser->execute($user);

        if ((bool) $request->activate_primary_character) {
            $this->activateUserPreviousCharacter->execute($user);
        }

        return $user;
    }
}
