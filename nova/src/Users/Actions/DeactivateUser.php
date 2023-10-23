<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Users\Models\States\Status\Inactive;
use Nova\Users\Models\User;

class DeactivateUser
{
    use AsAction;

    public function handle(User $user): User
    {
        if ($user->status->canTransitionTo(Inactive::class)) {
            $user->status->transitionTo(Inactive::class);

            activity()
                ->causedBy(auth()->user())
                ->performedOn($user)
                ->log(':subject.name was deactivated');
        }

        return $user->refresh();
    }
}
