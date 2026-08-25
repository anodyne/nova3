<?php

declare(strict_types=1);

namespace Nova\Users\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Actions\ActivateCharacter;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\CharacterUser;
use Nova\Users\Models\User;

class ActivateUserPreviousCharacter
{
    use AsAction;

    public function handle(User $user): void
    {
        $primaryCharacters = $user->characters->filter(
            function (Character $character): bool {
                $pivot = $character->getRelation('pivot');

                return $pivot instanceof CharacterUser && $pivot->primary !== true;
            }
        );

        if ($primaryCharacters->count() > 1) {
            $primaryCharacters->sortByDesc(
                function (Character $character): mixed {
                    $pivot = $character->getRelation('pivot');

                    return $pivot instanceof CharacterUser ? $pivot->updated_at : null;
                }
            );
        }

        $character = $primaryCharacters->first();

        if ($character instanceof Character) {
            ActivateCharacter::run($character);
        }
    }
}
