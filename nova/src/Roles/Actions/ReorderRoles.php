<?php

declare(strict_types=1);

namespace Nova\Roles\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Roles\Models\Role;

class ReorderRoles
{
    use AsAction;

    public function handle(array $items): void
    {
        collect($items)
            ->map(fn ($item) => $item['value'])
            ->each(fn ($id, $index) => Role::where('id', $id)->update(['sort' => $index]));
    }
}
