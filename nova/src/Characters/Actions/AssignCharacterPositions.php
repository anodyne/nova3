<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Data\AssignCharacterPositionsData;
use Nova\Characters\Models\Character;

class AssignCharacterPositions
{
    use AsAction;

    public function handle(Character $character, AssignCharacterPositionsData $data): Character
    {
        $positions = collect($data->positions)->filter();

        $character->positions()->sync($positions);

        return $character->refresh();
    }
}
