<?php

declare(strict_types=1);

namespace Nova\Menus\Actions;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Menus\Models\MenuItem;

class DeleteMenuItem
{
    use AsAction;

    public function handle(MenuItem $menuItem): MenuItem
    {
        return DB::transaction(function () use ($menuItem) {
            $menuItem->loadMissing('items');

            $menuItem->items->each->delete();

            $menuItem = tap($menuItem)->delete();

            return $menuItem;
        });
    }
}
