<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Users\Models\User;

class ActivateUserManager
{
    use AsAction;

    public function handle(User $user, bool $activatePreviousCharacter = false): User
    {
        $user = ActivateUser::run($user);

        ActivateUserPreviousCharacter::runIf($activatePreviousCharacter, $user);

        return $user->refresh();
    }
}
