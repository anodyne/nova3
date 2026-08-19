<?php

declare(strict_types=1);

namespace Nova\Users\Listeners;

use Illuminate\Support\Facades\Auth;
use Nova\Users\Exceptions\AdminForcedPasswordResetException;

class CheckForForcedPasswordReset
{
    public function handle($event): void
    {
        if ($event->user->force_password_reset) {
            Auth::logout();

            throw new AdminForcedPasswordResetException;
        }
    }
}
