<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Nova\Characters\Data\AssignCharacterPositionsData;
use Nova\Characters\Models\Character;
use Nova\Foundation\Actions\Action;

class AssignCharacterPositions extends Action
{
    public function handle(Character $character, AssignCharacterPositionsData $data): Character
    {
        $positions = collect($data->positions)->filter();

        $character->positions()->sync($positions);

        return $character->refresh();
    }
}
