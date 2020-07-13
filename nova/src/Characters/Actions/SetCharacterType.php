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
            $this->transition($character, Secondary::class);
        }

        $character->refresh();

        if ($character->primaryUsers()->count() > 0) {
            $this->transition($character, Primary::class);
        }

        return $character->refresh();
    }

    protected function transition(Character $character, $state)
    {
        if ($character->canTransitionTo($state, 'type')) {
            $character->type->transitionTo($state);
        }
    }
}
