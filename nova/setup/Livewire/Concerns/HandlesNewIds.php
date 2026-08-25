<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Concerns;

use Illuminate\Support\Collection;
use Nova\Setup\Models\Upgrade;

trait HandlesNewIds
{
    /** @param Collection<int, Upgrade>|null $collection */
    protected function getNewId(?int $id, ?Collection $collection, string $upgradeKey): ?int
    {
        if ($collection) {
            return $collection->firstWhere('old_id', $id)?->new_id;
        }

        return Upgrade::query()
            ->type($upgradeKey)
            ->where('old_id', $id)
            ->value('new_id');
    }
}
