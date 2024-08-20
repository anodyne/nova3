<?php

declare(strict_types=1);

namespace Nova\Menus\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Menus\Data\MenuItemData;
use Nova\Menus\Models\Menu;
use Nova\Menus\Models\MenuItem;

class CreateMenuItem
{
    use AsAction;

    public function handle(MenuItemData $data): MenuItem
    {
        $menu = Menu::public()->first();

        return $menu->items()->create($data->all());
    }
}
