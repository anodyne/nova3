<?php

declare(strict_types=1);

namespace Nova\Menus\Observers;

use Nova\Menus\Actions\BustMenusCache;
use Nova\Menus\Actions\RecacheMenus;
use Nova\Menus\Models\MenuItem;

class MenuItemObserver
{
    public function updated(MenuItem $menuItem): void
    {
        BustMenusCache::run();
        RecacheMenus::run();
    }
}
