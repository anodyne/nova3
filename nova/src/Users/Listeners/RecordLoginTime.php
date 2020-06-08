<?php

namespace Nova\Users\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RecordLoginTime implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {
        $event->user->logins()->create([
            'ip_address' => request()->ip(),
            'created_at' => now(),
        ]);
    }
}
