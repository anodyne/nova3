<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Status\Active;

class ActivateCharacter
{
    use AsAction;

    public function handle(Character $character): Character
    {
        if ($character->status->canTransitionTo(Active::class)) {
            activity()->withoutLogging(fn () => $character->status->transitionTo(Active::class));

            activity()
                ->performedOn($character)
                ->event('activated')
                ->log('activated');
        }

        return $character->refresh();
    }
}
