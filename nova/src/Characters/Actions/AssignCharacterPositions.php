<?php

namespace Nova\Characters\Actions;

use Illuminate\Http\Request;
use Nova\Characters\Models\Character;

class AssignCharacterPositions
{
    public function execute(Character $character, Request $request): Character
    {
        $positions = explode(',', $request->positions);

        collect($positions)->each(function ($positionId) use ($character, $request) {
            $character->positions()->attach($positionId, [
                'primary' => (int) $request->primary_position === (int) $positionId
            ]);
        });

        return $character->refresh();
    }
}
