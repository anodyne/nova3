<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Users\Models\States\Status\Inactive;
use Nova\Users\Models\User;

class DeactivateUser extends Action
{
    public function handle(User $user): User
    {
        if ($user->status->canTransitionTo(Inactive::class)) {
            $user->status->transitionTo(Inactive::class);

            activity()
                ->performedOn($user)
                ->event('deactivated')
                ->log('deactivated');
        }

        return $user->refresh();
    }
}
