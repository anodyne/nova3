<?php

namespace Nova\Roles\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Silber\Bouncer\BouncerFacade as Bouncer;

class RefreshPermissionsCache implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {
        Bouncer::refresh();
    }
}
