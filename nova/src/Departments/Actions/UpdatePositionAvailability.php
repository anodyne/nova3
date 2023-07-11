<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Characters\Data\AssignCharacterPositionsData;
use Nova\Departments\Models\Position;

class UpdatePositionAvailability
{
    use AsAction;

    public function handle(AssignCharacterPositionsData $data): void
    {
        $positions = Position::whereIn('id', $data->positions)->get();

        $positions->each(function (Position $position) {
            $settings = settings();
        });
    }
}
