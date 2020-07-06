<?php

namespace Nova\Characters\Actions;

use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Statuses\Active;

class ActivateCharacter
{
    public function execute(Character $character): Character
    {
        $character->status->transitionTo(Active::class);

        return $character->fresh();
    }
}
