<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Concerns;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

trait HandlesNewIds
{
    /** @param Collection<int, object>|null $collection */
    protected function getNewId(?int $id, ?Collection $collection, string $upgradeKey): ?int
    {
        $collection ??= DB::table('upgrade')->where('type', $upgradeKey);

        return $collection->where('old_id', $id)->first()?->new_id;
    }
}
