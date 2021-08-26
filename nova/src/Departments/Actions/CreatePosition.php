<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Nova\Departments\DataTransferObjects\PositionData;
use Nova\Departments\Models\Position;

class CreatePosition
{
    public function execute(PositionData $data): Position
    {
        return Position::create(array_merge(
            $data->except('department')->toArray(),
            [
                'sort' => $data->department->positions()->count(),
            ]
        ));
    }
}
