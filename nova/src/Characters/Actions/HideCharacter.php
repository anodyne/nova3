<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Status\Hidden;
use Nova\Foundation\Actions\Action;

class HideCharacter extends Action
{
    public function handle(Character $character): Character
    {
        if ($character->status->canTransitionTo(Hidden::class)) {
            activity()->withoutLogging(fn () => $character->status->transitionTo(Hidden::class));

            activity()
                ->performedOn($character)
                ->event('hidden')
                ->log('hidden');
        }

        return $character->refresh();
    }
}
