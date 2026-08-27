<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Lorisleiva\Actions\Concerns\AsObject;
use Nova\Users\Models\User;

class DeleteUserNotifications
{
    use AsObject;

    public function handle(User $user): void
    {
        $user->notificationPreferences()->delete();

        $user->notifications()->delete();
    }
}
