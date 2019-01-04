<?php

namespace Nova\Users\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
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

            throw new AdminForcedPasswordResetException;
        }
    }
}
