<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Nova\Foundation\Action;
use Nova\Users\Models\User;
use Spatie\ModelStates\State;

class UpdateUserStatus extends Action
{
    public function execute(User $user, $status): User
    {
        if ($status) {
            $newStatus = State::make($status, $user);

            if ((string) $user->status !== (string) $newStatus) {
                $user->status->transitionTo($newStatus);
            }
        }

        return $user->fresh();
    }
}
