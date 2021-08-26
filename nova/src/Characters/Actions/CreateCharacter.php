<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Nova\Characters\DataTransferObjects\CharacterData;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Statuses\Active;

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
