<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Nova\Characters\Data\CharacterData;
use Nova\Characters\Models\Character;
use Nova\Foundation\Actions\Action;

class CreateCharacter extends Action
{
    public function handle(CharacterData $data): Character
    {
        return Character::create($data->toArray());
    }
}
