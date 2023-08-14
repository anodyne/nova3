<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Status\Active;
use Nova\Characters\Notifications\PendingCharacterApproved;

class ApproveCharacter
{
    use AsAction;

    public function handle(Character $character): Character
    {
        if ($character->status->canTransitionTo(Active::class)) {
            $character->status->transitionTo(Active::class);

            $character->activeUsers->each->notify(new PendingCharacterApproved($character));

            activity()
                ->causedBy(auth()->user())
                ->performedOn($character)
                ->log(':subject.name was approved');
        }

        return $character->refresh();
    }
}
