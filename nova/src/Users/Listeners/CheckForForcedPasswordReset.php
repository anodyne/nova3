<?php

declare(strict_types=1);

namespace Nova\Users\Listeners;

use Illuminate\Auth\Events\Authenticated;
use Illuminate\Support\Facades\Auth;
use Nova\Users\Exceptions\AdminForcedPasswordResetException;
use Nova\Users\Models\User;

class CheckForForcedPasswordReset
{
    public function handle(Authenticated $event): void
    {
        if ($event->user instanceof User && $event->user->force_password_reset) {
            Auth::logout();

            throw new AdminForcedPasswordResetException;
        }
    }
}
