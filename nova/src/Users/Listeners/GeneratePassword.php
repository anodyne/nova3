<?php

declare(strict_types=1);

namespace Nova\Users\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use NicoBleiler\Passphrase\Facades\Passphrase;
use Nova\Users\Events\UserCreatedByAdmin;
use Nova\Users\Notifications\AccountCreated;

class GeneratePassword implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(UserCreatedByAdmin $event)
    {
        $passphrase = Passphrase::generate();

        $event->user->update(['password' => $passphrase]);

        $event->user->notify(new AccountCreated($event->user, $passphrase));
    }
}
