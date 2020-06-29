<?php

namespace Nova\Characters\Actions;

use Nova\Foundation\Action;
use Spatie\ModelStates\State;
use Nova\Characters\Models\Character;

class UpdateCharacterStatus extends Action
{
    public function execute(Character $character, $status): Character
    {
        $newStatus = State::make($status, $character);

        if ((string) $character->status !== (string) $newStatus) {
            $character->status->transitionTo($newStatus);
        }

        return $character->fresh();
    }
}
