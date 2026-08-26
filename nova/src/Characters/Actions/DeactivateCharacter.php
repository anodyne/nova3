<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Status\Inactive;

class DeactivateCharacter
{
    use AsAction;

    public function handle(Character $character): Character
    {
        if ($character->status->canTransitionTo(Inactive::class)) {
            activity()->withoutLogging(fn () => $character->status->transitionTo(Inactive::class));

            activity()
                ->performedOn($character)
                ->event('deactivated')
                ->log('deactivated');
        }

        return $character->refresh();
    }
}
