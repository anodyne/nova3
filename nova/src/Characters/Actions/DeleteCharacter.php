<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Nova\Characters\Models\Character;
use Nova\Foundation\Actions\Action;

class DeleteCharacter extends Action
{
    public function handle(Character $character): Character
    {
        if (! $character->trashed()) {
            return tap($character)->delete();
        }

        return $character;
    }
}
