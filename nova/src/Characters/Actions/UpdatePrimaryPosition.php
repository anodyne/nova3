<?php

declare(strict_types=1);

namespace Nova\Characters\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Position;

class UpdatePrimaryPosition
{
    use AsAction;

    public function handle(Character $character, Position $position): Character
    {
        $character->positions()
            ->newPivotStatement()
            ->where('character_id', '=', $character->id)
            ->update(['primary' => false]);

        $character->positions()->updateExistingPivot(
            $position->id,
            ['primary' => true]
        );

        return $character->refresh();
    }
}
