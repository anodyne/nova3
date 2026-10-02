<?php

declare(strict_types=1);

namespace Nova\Menus\Actions;

use Illuminate\Support\Facades\DB;
use Nova\Foundation\Actions\Action;
use Nova\Menus\Models\MenuItem;

class DeleteMenuItem extends Action
{
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
