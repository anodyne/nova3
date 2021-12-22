<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Departments\Data\PositionData;
use Nova\Departments\Models\Position;

class CreatePosition
{
    use AsAction;

    public function handle(PositionData $data): Position
    {
        return Position::create(array_merge(
            Arr::except($data->all(), 'department'),
            [
                'sort' => $data->department->positions()->count(),
            ]
        ));
    }
}
