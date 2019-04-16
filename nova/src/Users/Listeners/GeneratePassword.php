<?php

namespace Nova\Users\Listeners;

use Nova\Users\Events\Created;
use Nova\Foundation\WordGenerator;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Nova\Users\Notifications\AccountCreated;

class GeneratePassword implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(Created $event)
    {
        $password = implode('-', (new WordGenerator)->words(4));

        $event->user->update(['password' => $password]);

        $event->user->notify(new AccountCreated($password));
    }
}
