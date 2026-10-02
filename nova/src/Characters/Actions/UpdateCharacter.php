<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Nova\Characters\Data\CharacterData;
use Nova\Characters\Models\Character;
use Nova\Foundation\Actions\Action;

class UpdateCharacter extends Action
{
    public function handle(Character $character, CharacterData $data): Character
    {
        return tap($character)
            ->update($data->toArray())
            ->refresh();
    }
}
