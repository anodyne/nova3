<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Status\Inactive;

class DenyCharacter
{
    use AsAction;

    public function handle(Character $character): Character
    {
        if ($character->status->canTransitionTo(Inactive::class)) {
            $character->status->transitionTo(Inactive::class);

            activity()
                ->causedBy(auth()->user())
                ->performedOn($character)
                ->log(':subject.name was denied');
        }

        return $character->refresh();
    }
}
