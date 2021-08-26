<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Nova\Departments\DataTransferObjects\PositionData;
use Nova\Departments\Models\Position;

class UpdatePosition
{
    public function execute(Position $position, PositionData $data): Position
    {
        return tap($position)->update(
            $data->except('department')->toArray()
        )->refresh();
    }
}
