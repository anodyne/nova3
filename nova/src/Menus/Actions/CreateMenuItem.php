<?php

declare(strict_types=1);

namespace Nova\Menus\Actions;

use Nova\Foundation\Actions\Action;
use Nova\Menus\Data\MenuItemData;
use Nova\Menus\Models\Menu;
use Nova\Menus\Models\MenuItem;

class CreateMenuItem extends Action
{
    public function handle(MenuItemData $data): MenuItem
    {
        $menu = Menu::public()->first();
        $menuItem = new MenuItem($data->toArray());

        $menu->items()->save($menuItem);

        return $menuItem;
    }
}
