<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Status\Hidden;

class HideCharacter
{
    use AsAction;

    public function handle(Character $character): Character
    {
        if ($character->status->canTransitionTo(Hidden::class)) {
            $character->status->transitionTo(Hidden::class);

            activity()
                ->performedOn($character)
                ->event('hidden')
                ->log('hidden');
        }

        return $character->refresh();
    }
}
