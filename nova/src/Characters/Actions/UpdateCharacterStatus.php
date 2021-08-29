<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Models\Character;
use Nova\Foundation\Action;
use Spatie\ModelStates\State;

class UpdateCharacterStatus extends Action
{
    use AsAction;

    public function handle(Character $character, $status): Character
    {
        $newStatus = State::make($status, $character);

        if ((string) $character->status !== (string) $newStatus) {
            $character->status->transitionTo($newStatus);
        }

        return $character->refresh();
    }
}
