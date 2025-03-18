<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Concerns;

use Illuminate\Support\Collection;
use Nova\Setup\Models\Upgrade;

trait HandlesNewIds
{
    protected function getNewId(?int $id, ?Collection $collection, string $upgradeKey): ?int
    {
        $collection ??= Upgrade::type($upgradeKey);

        return $collection->where('old_id', $id)->first()?->new_id;
    }
}
