<?php

namespace Nova\Roles\Listeners;

use Bouncer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RefreshPermissionsCache implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {
        Bouncer::refresh();
    }
}
