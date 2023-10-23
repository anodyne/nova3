<?php

declare(strict_types=1);

namespace Nova\Users\Listeners;

use Lab404\Impersonate\Events\LeaveImpersonation;

class LogImpersonationEnd
{
    public function handle(LeaveImpersonation $event): void
    {
        activity('impersonation')
            ->causedBy($event->impersonator)
            ->performedOn($event->impersonated)
            ->event('ended impersonation')
            ->log('Impersonation session ended for '.$event->impersonated->name);
    }
}
