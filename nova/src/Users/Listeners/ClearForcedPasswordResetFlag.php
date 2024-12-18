<?php

declare(strict_types=1);

namespace Nova\Users\Listeners;

class ClearForcedPasswordResetFlag
{
    public function handle($event)
    {
        $event->user->update(['force_password_reset' => false]);
    }
}
