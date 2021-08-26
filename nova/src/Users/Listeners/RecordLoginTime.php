<?php

declare(strict_types=1);

namespace Nova\Users\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
