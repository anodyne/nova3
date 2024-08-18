<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Illuminate\Support\Facades\Auth;
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
                ->causedBy(Auth::user())
                ->performedOn($character)
                ->log(':subject.name was hidden');
        }

        return $character->refresh();
    }
}
