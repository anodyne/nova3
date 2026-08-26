<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Users\Exceptions\CannotDeleteOwnAccountException;
use Nova\Users\Models\User;

class DeleteUser
{
    use AsAction;

    public function handle(User $user): User
    {
        throw_if(
            $user->is(Auth::user()),
            CannotDeleteOwnAccountException::class
        );

        $user->announcementNotifications()->delete();

        $user->logins()->delete();

        $user->notifications()->delete();

        $user->notificationPreferences()->delete();

        $user->onboardings()->delete();

        $user->statusHistories()->delete();

        $user->delete();

        return $user;
    }
}
