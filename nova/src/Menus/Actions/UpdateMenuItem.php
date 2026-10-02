<?php

declare(strict_types=1);

namespace Nova\Menus\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Menus\Data\MenuItemData;
use Nova\Menus\Models\MenuItem;

class UpdateMenuItem extends Action
{
    public function handle(MenuItem $menuItem, MenuItemData $data): MenuItem
    {
        return tap($menuItem)->update($data->toArray());
    }
}
