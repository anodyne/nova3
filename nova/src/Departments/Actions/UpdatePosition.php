<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Departments\Data\PositionData;
use Nova\Departments\Models\Position;

class UpdatePosition
{
    use AsAction;

    public function handle(Position $position, PositionData $data): Position
    {
        return tap($position)
            ->update($data->all())
            ->refresh();
    }
}
