<?php

declare(strict_types=1);

namespace Nova\Users\Listeners;

use Lab404\Impersonate\Events\TakeImpersonation;
use Nova\Users\Models\User;

class LogImpersonationStart
{
    public function handle(TakeImpersonation $event): void
    {
        /** @var User $impersonated */
        $impersonated = $event->impersonated;

        /** @var User $impersonator */
        $impersonator = $event->impersonator;

        activity('impersonation')
            ->causedBy($impersonator)
            ->performedOn($impersonated)
            ->event('started impersonation')
            ->log('started impersonation');
    }
}
