<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Illuminate\Support\Facades\Notification;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Models\Character;
use Nova\Characters\Notifications\CharacterNeedsApproval;
use Nova\Users\Models\User;

class SendPendingCharacterNotification
{
    use AsAction;

    public function handle(Character $character): void
    {
        $users = User::wherePermissionIs('character.update')->get();

        Notification::send($users, new CharacterNeedsApproval($character));
    }
}
