<?php

namespace Nova\Users\Listeners;

use DB;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForceLogout
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        DB::table('sessions')->where('user_id', $event->user->id)->delete();
    }
}
