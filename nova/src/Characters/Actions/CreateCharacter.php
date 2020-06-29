<?php

namespace Nova\Characters\Actions;

use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Active;
use Nova\Characters\DataTransferObjects\CharacterData;

class CreateCharacter
{
    public function execute(CharacterData $data): Character
    {
        return Character::create(array_merge(
            $data->toArray(),
            ['status' => Active::class]
        ));
    }
}
