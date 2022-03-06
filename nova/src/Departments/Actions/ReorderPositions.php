<?php

declare(strict_types=1);

namespace Nova\Departments\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Departments\Models\Position;

class ReorderPositions
{
    use AsAction;

    public function handle(array $items): void
    {
        collect($items)
            ->map(fn ($item) => $item['value'])
            ->each(fn ($id, $index) => Position::where('id', $id)->update(['sort' => $index]));
    }
}
