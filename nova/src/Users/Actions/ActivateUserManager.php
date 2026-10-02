<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Illuminate\Support\Facades\DB;
use Nova\Foundation\Actions\Action;
use Nova\Users\Models\User;

class ActivateUserManager extends Action
{
    public function handle(User $user, bool $activatePreviousCharacter = false): User
    {
        return DB::transaction(function () use ($user, $activatePreviousCharacter) {
            $user = ActivateUser::run($user);

            ActivateUserPreviousCharacter::runIf($activatePreviousCharacter, $user);

            return $user->refresh();
        });
    }
}
