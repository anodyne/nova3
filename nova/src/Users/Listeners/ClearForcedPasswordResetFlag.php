<?php

declare(strict_types=1);

namespace Nova\Users\Listeners;

use Illuminate\Auth\Events\PasswordReset;

class ClearForcedPasswordResetFlag
{
    public function handle(PasswordReset $event): void
    {
        $event->user->update(['force_password_reset' => false]);
    }
}
