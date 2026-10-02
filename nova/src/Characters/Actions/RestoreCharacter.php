<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Nova\Characters\Models\Character;
use Nova\Foundation\Actions\Action;

class RestoreCharacter extends Action
{
    public function handle(Character $character): Character
    {
        if ($character->trashed()) {
            activity()->withoutLogging(fn () => $character->restore());

            activity()
                ->performedOn($character)
                ->event('restored')
                ->log('restored');
        }

        return $character->refresh();
    }
}
