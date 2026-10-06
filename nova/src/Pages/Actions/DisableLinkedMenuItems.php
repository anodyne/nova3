<?php

declare(strict_types=1);

namespace Nova\Pages\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Menus\Actions\BustMenusCache;
use Nova\Menus\Actions\RecacheMenus;
use Nova\Pages\Models\Page;

class DisableLinkedMenuItems extends Action
{
    public function handle(Page $page): void
    {
        if ($page->status === BasicStatus::Inactive) {
            // If the page is inactive, we need to disable any menu items associated
            // with the page to also be inactive, otherwise we will have 404 errors
            // and route not found exceptions thrown on the public site
            $page->menuItems()->update(['status' => BasicStatus::Inactive]);

            BustMenusCache::run();
            RecacheMenus::run();
        }
    }
}
