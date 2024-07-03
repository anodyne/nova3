<?php

declare(strict_types=1);

namespace Nova\Users\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Nova\Foundation\WordGenerator;
use Nova\Users\Events\UserCreatedByAdmin;
use Nova\Users\Notifications\AccountCreated;

class GeneratePassword implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(UserCreatedByAdmin $event)
    {
        $password = implode('-', (new WordGenerator())->words(4));

        $event->user->update(['password' => $password]);

        $event->user->notify(new AccountCreated($event->user, $password));
    }
}
