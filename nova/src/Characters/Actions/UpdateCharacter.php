<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Nova\Characters\DataTransferObjects\CharacterData;
use Nova\Characters\Models\Character;

class UpdateCharacter
{
    public function execute(Character $character, CharacterData $data): Character
    {
        return tap($character)
            ->update($data->toArray())
            ->refresh();
    }
}
