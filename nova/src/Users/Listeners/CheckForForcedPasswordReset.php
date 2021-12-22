<?php

declare(strict_types=1);

namespace Nova\Users\Listeners;

use Nova\Users\Exceptions\UserException;

class CheckForForcedPasswordReset
{
    public function handle($event)
    {
        if ($event->user->force_password_reset) {
            UserException::adminForcedPasswordReset();
        }
    }
}
