<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Users\Models\User;

class RemoveUserAvatar
{
    use AsAction;

    public function handle(User $user, bool $remove = false): User
    {
        if ($remove) {
            activity()
                ->performedOn($user)
                ->event('removed avatar')
                ->log('removed avatar');

            $user->clearMediaCollection('avatar');
        }

        return $user->refresh();
    }
}
