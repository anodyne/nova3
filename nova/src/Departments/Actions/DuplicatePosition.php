<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Departments\Data\PositionData;
use Nova\Departments\Models\Position;

class DuplicatePosition
{
    use AsAction;

    public function handle(Position $original, PositionData $data): Position
    {
        $position = $original->replicate();
        $position->forceFill(collect($data->all())->filter()->toArray());
        $position->save();

        return $position->refresh();
    }
}
