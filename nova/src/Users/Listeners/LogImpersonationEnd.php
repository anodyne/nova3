<?php

declare(strict_types=1);

namespace Nova\Users\Listeners;

use Lab404\Impersonate\Events\LeaveImpersonation;
use Nova\Users\Models\User;

class LogImpersonationEnd
{
    public function handle(LeaveImpersonation $event): void
    {
        /** @var User $impersonated */
        $impersonated = $event->impersonated;

        /** @var User $impersonator */
        $impersonator = $event->impersonator;

        activity('impersonation')
            ->causedBy($impersonator)
            ->performedOn($impersonated)
            ->event('ended impersonation')
            ->log('ended impersonation');
    }
}
