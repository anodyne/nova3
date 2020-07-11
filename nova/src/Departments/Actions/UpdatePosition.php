<?php

namespace Nova\Departments\Actions;

use Nova\Departments\Models\Position;
use Nova\Departments\DataTransferObjects\PositionData;

class UpdatePosition
{
    public function execute(Position $position, PositionData $data): Position
    {
        return tap($position)->update(
            $data->except('department')->toArray()
        )->refresh();
    }
}
