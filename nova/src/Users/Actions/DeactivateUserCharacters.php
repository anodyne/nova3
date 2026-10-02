<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Nova\Characters\Actions\DeactivateCharacter;
use Nova\Foundation\Actions\Action;
use Nova\Users\Models\User;

class DeactivateUserCharacters extends Action
{
    public function handle(User $user): User
    {
        $user->activeCharacters->each(
            fn ($character): mixed => DeactivateCharacter::run($character)
        );

        return $user->refresh();
    }
}
