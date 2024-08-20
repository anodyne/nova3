<?php

declare(strict_types=1);

namespace Nova\Menus\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Menus\Data\MenuItemData;
use Nova\Menus\Models\MenuItem;

class UpdateMenuItem
{
    use AsAction;

    public function handle(MenuItem $menuItem, MenuItemData $data): MenuItem
    {
        return tap($menuItem)->update($data->all());
    }
}
