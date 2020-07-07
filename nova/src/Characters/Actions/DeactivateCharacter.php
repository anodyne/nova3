<?php

namespace Nova\Characters\Actions;

use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Statuses\Inactive;

class DeactivateCharacter
{
    public function execute(Character $character): Character
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($character)
            ->log(':subject.name was deactivated');

        $character->status->transitionTo(Inactive::class);

        return $character->fresh();
    }
}
