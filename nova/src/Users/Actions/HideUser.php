<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Users\Models\States\Status\Hidden;
use Nova\Users\Models\User;

class HideUser
{
    use AsAction;

    public function handle(User $user): User
    {
        if ($user->status->canTransitionTo(Hidden::class)) {
            $user->status->transitionTo(Hidden::class);

            activity()
                ->performedOn($user)
                ->event('hidden')
                ->log('hidden');
        }

        return $user->refresh();
    }
}
