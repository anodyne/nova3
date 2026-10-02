<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Nova\Departments\Data\PositionData;
use Nova\Departments\Models\Position;
use Nova\Foundation\Actions\Action;

class CreatePosition extends Action
{
    public function handle(PositionData $data): Position
    {
        return Position::create($data->toArray());
    }
}
