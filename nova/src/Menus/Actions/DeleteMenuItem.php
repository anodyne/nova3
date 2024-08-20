<?php

declare(strict_types=1);

namespace Nova\Menus\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Menus\Models\MenuItem;

class DeleteMenuItem
{
    use AsAction;

    public function handle(MenuItem $menuItem): MenuItem
    {
        $menuItem->loadMissing('items');

        $menuItem->items->each->delete();

        return tap($menuItem)->delete();
    }
}
