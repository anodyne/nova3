<?php

namespace Nova\Characters\Actions;

use Nova\Characters\Models\Character;
use Nova\Characters\DataTransferObjects\AssignCharacterPositionsData;

class AssignCharacterPositions
{
    public function execute(Character $character, AssignCharacterPositionsData $data): Character
    {
        collect($data->positions)->each(function ($positionId) use ($character, $data) {
            $character->positions()->attach($positionId, [
                'primary' => (int) $data->primaryPosition === (int) $positionId,
            ]);
        });

        return $character->refresh();
    }
}
