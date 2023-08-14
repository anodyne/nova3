<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Models\Character;

class RestoreCharacter
{
    use AsAction;

    public function handle(Character $character): Character
    {
        if ($character->trashed()) {
            $character->restore();

            activity()
                ->causedBy(auth()->user())
                ->performedOn($character)
                ->log(':subject.name was restored');
        }

        return $character->refresh();
    }
}
