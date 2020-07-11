<?php

namespace Nova\Characters\Actions;

use Nova\Characters\Models\Character;
use Nova\Characters\DataTransferObjects\CharacterData;

class UpdateCharacter
{
    public function execute(Character $character, CharacterData $data): Character
    {
        return tap($character)
            ->update($data->toArray())
            ->refresh();
    }
}
