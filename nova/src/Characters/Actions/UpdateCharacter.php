<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Data\CharacterData;
use Nova\Characters\Models\Character;

class UpdateCharacter
{
    use AsAction;

    public function handle(Character $character, CharacterData $data): Character
    {
        return tap($character)
            ->update($data->toArray())
            ->refresh();
    }
}
