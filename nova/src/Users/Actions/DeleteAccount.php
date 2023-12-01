<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Users\Models\User;

class DeleteAccount
{
    use AsAction;

    public function handle(User $user): void
    {
        // Detach any characters

        // Detach any story posts

        // Detach any announcements

        // Detach from any direct messages

        $user->notes()->delete();

        $user->logins()->delete();

        $user->clearMediaCollection('avatar');

        $user->delete();
    }
}
