<?php

namespace Nova\Characters\Actions;

use Nova\Characters\Models\Character;
use Nova\Characters\DataTransferObjects\AssignCharacterPositionsData;

// 1 position
    // We assume that it's the primary
// 2 + x positions, 0 primary
// 2 + x positions, 1 primary

class AssignCharacterPositions
{
    public function execute(Character $character, AssignCharacterPositionsData $data): Character
    {
        $positions = collect($data->positions);

        $characterMap = $positions->mapWithKeys(function ($position) {
            return [$position => ['primary' => false]];
        })->all();

        // $characterMap = collect($data->positions)
        //     ->map(function ($positionId) use ($character, $data) {
        //         return [$positionId => [
        //             'primary' => (int) $data->primaryPosition === (int) $positionId,
        //         ]];
        //         // $character->positions()->sync($positionId, [
        //         //     'primary' => (int) $data->primaryPosition === (int) $positionId,
        //         // ]);
        //     });

        dd($characterMap);

        $character->positions()->sync($characterMap);

        return $character->refresh();
    }
}
