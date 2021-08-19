<?php

namespace Nova\Departments\Actions;

use Nova\Departments\DataTransferObjects\PositionData;
use Nova\Departments\Models\Position;

class DuplicatePosition
{
    public function execute(Position $original, PositionData $data): Position
    {
        $position = $original->replicate()->fill($data->toArray());

        $position->save();

        return $position->fresh();
    }
}
