<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Data\CharacterData;
use Nova\Characters\Models\Character;

class CreateCharacter
{
    use AsAction;

    public function handle(CharacterData $data): Character
    {
        return Character::create($data->all());
    }
}
