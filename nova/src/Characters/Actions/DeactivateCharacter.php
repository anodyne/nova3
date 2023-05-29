<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Statuses\Inactive;

class DeactivateCharacter
{
    use AsAction;

    public function handle(Character $character): Character
    {
        if ($character->status->canTransitionTo(Inactive::class)) {
            activity()
                ->causedBy(auth()->user())
                ->performedOn($character)
                ->log(':subject.name was deactivated');

            $character->status->transitionTo(Inactive::class);
        }

        return $character->refresh();
    }
}
