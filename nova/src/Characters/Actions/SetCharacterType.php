<?php

namespace Nova\Characters\Actions;

use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Types\Primary;
use Nova\Characters\Models\States\Types\Secondary;

class SetCharacterType
{
    public function execute(Character $character): Character
    {
        if ($character->activeUsers()->count() > 0) {
            $character->type->transitionTo(Secondary::class);
        }

        if ($character->primaryUsers()->count() > 0) {
            $character->type->transitionTo(Primary::class);
        }

        return $character->refresh();
    }
}
