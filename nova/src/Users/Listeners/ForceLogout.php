<?php

declare(strict_types=1);

namespace Nova\Users\Listeners;

use Illuminate\Support\Facades\DB;

class ForceLogout
{
    public function handle($event)
    {
        DB::table('sessions')->where('user_id', $event->user->id)->delete();
    }
}
