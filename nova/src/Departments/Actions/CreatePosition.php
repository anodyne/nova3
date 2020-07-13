<?php

namespace Nova\Departments\Actions;

use Nova\Departments\Models\Position;
use Nova\Departments\DataTransferObjects\PositionData;

class CreatePosition
{
    public function execute(PositionData $data): Position
    {
        return Position::create(array_merge(
            $data->except('department')->toArray(), [
                'sort' => $data->department->positions()->count(),
            ]
        ));
    }
}
