<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Types\Primary;
use Nova\Characters\Models\States\Types\Secondary;

class SetCharacterType
{
    use AsAction;

    public function handle(Character $character): Character
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

    protected function transition(Character $character, $state): void
    {
        if ($character->type->canTransitionTo($state)) {
            $character->type->transitionTo($state);
        }
    }
}
