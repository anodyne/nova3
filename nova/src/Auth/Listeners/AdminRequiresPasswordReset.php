<?php

namespace Nova\Auth\Listeners;

use \Iluminate\Auth\Events\Attempting;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminRequiresPasswordReset
{
    /**
     * Handle the event.
     *
     * @param  Attempting  $event
     * @return void
     */
    public function handle(Attempting $event)
    {
        if ($event->user->reset_required) {
			return redirect()->route('password.reset');
		}
    }
}
