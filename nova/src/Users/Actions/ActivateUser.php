<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Users\Models\States\Status\Active;
use Nova\Users\Models\User;

class ActivateUser
{
    use AsAction;

    public function handle(User $user): User
    {
        if ($user->status->canTransitionTo(Active::class)) {
            $user->status->transitionTo(Active::class);

            activity()
                ->causedBy(auth()->user())
                ->performedOn($user)
                ->log(':subject.name was activated');
        }

        return $user->refresh();
    }
}
