<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Nova\Departments\Data\PositionData;
use Nova\Departments\Models\Position;
use Nova\Foundation\Actions\Action;

class UpdatePosition extends Action
{
    public function handle(Position $position, PositionData $data): Position
    {
        return tap($position)
            ->update($data->toArray())
            ->refresh();
    }
}
