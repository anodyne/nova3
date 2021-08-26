<?php

declare(strict_types=1);

namespace Nova\Users\Listeners;

use Nova\Users\Exceptions\AdminForcedPasswordResetException;

class CheckForForcedPasswordReset
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if ($event->user->force_password_reset) {
            auth()->logout();

            throw new AdminForcedPasswordResetException();
        }
    }
}
