<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Departments\Models\Position;

class ReorderPositions
{
    use AsAction;

    public function handle(string $sort): void
    {
        collect(explode(',', $sort))->each(function ($positionId, $index) {
            Position::where('id', $positionId)->update(['sort' => $index]);
        });
    }
}
