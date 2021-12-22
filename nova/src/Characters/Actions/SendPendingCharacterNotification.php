<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Illuminate\Support\Facades\Notification;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Statuses\Pending;
use Nova\Characters\Notifications\CharacterRequiresApproval;
use Nova\Users\Models\User;

class SendPendingCharacterNotification
{
    use AsAction;

    public function handle(Character $character, User $user): void
    {
        if ($character->status->is(Pending::class)) {
            $users = User::wherePermissionIs('character.update')->get();

            Notification::send(
                $users,
                new CharacterRequiresApproval(character: $character, user: $user)
            );
        }
    }
}
