<?php

declare(strict_types=1);

namespace Nova\Menus\Listeners;

use Nova\Foundation\Events\ModelOrderChanged;
use Nova\Menus\Actions\BustMenusCache;
use Nova\Menus\Actions\RecacheMenus;
use Nova\Menus\Models\MenuItem;

class RecacheAfterReordering
{
    public function handle(ModelOrderChanged $event): void
    {
        if ($event->model === MenuItem::class) {
            BustMenusCache::run();
            RecacheMenus::run();
        }
    }
}
