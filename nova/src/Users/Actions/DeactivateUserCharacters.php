<?php

namespace Nova\Users\Actions;

use Nova\Characters\Actions\DeactivateCharacter;
use Nova\Users\Models\User;

class DeactivateUserCharacters
{
    protected $deactivateCharacter;

    public function __construct(DeactivateCharacter $deactivateCharacter)
    {
        $this->deactivateCharacter = $deactivateCharacter;
    }

    public function execute(User $user): User
    {
        $user->activeCharacters->each(function($character) {
            $this->deactivateCharacter->execute($character);
        });

        return $user->refresh();
    }
}
