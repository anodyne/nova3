<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Actions\ActivateCharacter;
use Nova\Users\Models\User;

class ActivateUserPreviousCharacter
{
    use AsAction;

    public function handle(User $user): void
    {
        $primaryCharacters = $user->characters->filter(
            fn ($character) => $character->pivot->primary !== true
        );

        if ($primaryCharacters->count() > 1) {
            $primaryCharacters->sortByDesc(
                fn ($character) => $character->pivot->updated_at
            );
        }

        ActivateCharacter::run($primaryCharacters->first());
    }
}
