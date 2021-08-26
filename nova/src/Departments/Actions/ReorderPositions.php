<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Nova\Departments\Models\Position;

class ReorderPositions
{
    public function execute(string $sort): void
    {
        collect(explode(',', $sort))->each(function ($positionId, $index) {
            Position::where('id', $positionId)->update(['sort' => $index]);
        });
    }
}
