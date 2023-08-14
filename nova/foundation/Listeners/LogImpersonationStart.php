<?php

declare(strict_types=1);

namespace Nova\Foundation\Listeners;

use Lab404\Impersonate\Events\TakeImpersonation;

class LogImpersonationStart
{
    public function handle(TakeImpersonation $event): void
    {
        activity('impersonation')
            ->causedBy($event->impersonator)
            ->performedOn($event->impersonated)
            ->event('started impersonation')
            ->log('Impersonation session started for '.$event->impersonated->name);
    }
}
