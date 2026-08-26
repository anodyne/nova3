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
            activity()->withoutLogging(fn () => $character->restore());

            activity()
                ->performedOn($character)
                ->event('restored')
                ->log('restored');
        }

        return $character->refresh();
    }
}
