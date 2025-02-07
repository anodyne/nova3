<?php

declare(strict_types=1);

namespace Nova\Menus\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Menus\Models\MenuItem;
use Spatie\Activitylog\Facades\LogBatch;

class DeleteMenuItem
{
    use AsAction;

    public function handle(MenuItem $menuItem): MenuItem
    {
        return DB::transaction(function () use ($menuItem) {
            $menuItem->loadMissing('items');

            LogBatch::startBatch();

            $menuItem->items->each->delete();

            $menuItem = tap($menuItem)->delete();

            LogBatch::endBatch();

            return $menuItem;
        });
    }
}
