<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Actions\DeactivateCharacter;
use Nova\Users\Models\User;

class DeactivateUserCharacters
{
    use AsAction;

    public function handle(User $user): User
    {
        $user->activeCharacters->each(
            fn ($character) => DeactivateCharacter::run($character)
        );

        return $user->refresh();
    }
}
