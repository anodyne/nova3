<?php

namespace Nova\Characters\Actions;

use Nova\Characters\Models\Character;
use Nova\Characters\DataTransferObjects\AssignCharacterPositionsData;

class AssignCharacterPositions
{
    public function execute(Character $character, AssignCharacterPositionsData $data): Character
    {
        $positions = collect($data->positions);

        $characterMap = $positions->mapWithKeys(function ($position) use ($positions, $data) {
            $primary = ($positions->count() === 1)
                ? ['primary' => true]
                : ['primary' => (int) $data->primaryPosition === (int) $position];

            return [$position => $primary];
        })->all();

        $character->positions()->sync($characterMap);

        return $character->refresh();
    }
}
