<?php

namespace Nova\Users\Actions;

use Nova\Characters\Actions\ActivateCharacter;
use Nova\Users\Models\User;

class ActivateUserPreviousCharacter
{
    protected $activateCharacter;

    public function __construct(ActivateCharacter $activateCharacter)
    {
        $this->activateCharacter = $activateCharacter;
    }

    public function execute(User $user): void
    {
        $primaryCharacters = $user->characters->filter(function ($character) {
            return $character->pivot->primary !== true;
        });

        if ($primaryCharacters->count() > 1) {
            $primaryCharacters->sortByDesc(function ($character) {
                return $character->pivot->updated_at;
            });
        }

        $this->activateCharacter->execute($primaryCharacters->first());
    }
}
