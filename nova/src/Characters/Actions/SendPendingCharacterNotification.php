<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Illuminate\Support\Facades\Notification;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Models\Character;
use Nova\Characters\Notifications\CharacterRequiresApproval;
use Nova\Users\Models\User;

class SendPendingCharacterNotification
{
    use AsAction;

    public function handle(Character $character, User $user): void
    {
        if ($character->is_pending) {
            Notification::send(
                User::whereHasPermission('character.update')->get(),
                new CharacterRequiresApproval(character: $character, user: $user)
            );
        }
    }
}
