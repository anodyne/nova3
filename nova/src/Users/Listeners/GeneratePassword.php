<?php

namespace Nova\Users\Listeners;

use Nova\Foundation\WordGenerator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Queue\InteractsWithQueue;
use Nova\Users\Events\UserCreatedByAdmin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Nova\Users\Notifications\AccountCreated;

class GeneratePassword implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(UserCreatedByAdmin $event)
    {
        $password = implode('-', (new WordGenerator)->words(4));

        $event->user->update(['password' => Hash::make($password)]);

        $event->user->notify(new AccountCreated($password));
    }
}
