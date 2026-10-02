<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Users\Models\User;

class UploadUserAvatar extends Action
{
    public function handle(User $user, ?string $path = null): User
    {
        if (is_null($path)) {
            $user->clearMediaCollection('avatar');

            activity()
                ->performedOn($user)
                ->event('removed avatar')
                ->log('removed avatar');
        } else {
            $user->addMedia($path)->toMediaCollection('avatar');

            activity()
                ->performedOn($user)
                ->event('uploaded avatar')
                ->log('uploaded avatar');
        }

        return $user->refresh();
    }
}
