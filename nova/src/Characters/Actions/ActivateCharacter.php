<?php

namespace Nova\Characters\Actions;

use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Statuses\Active;

class ActivateCharacter
{
    public function execute(Character $character): Character
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($character)
            ->log(':subject.name was activated');

        $character->status->transitionTo(Active::class);

        return $character->fresh();
    }
}
