<?php

declare(strict_types=1);

namespace Nova\Menus\Providers;

use Nova\DomainServiceProvider;
use Nova\Menus\Livewire\MenuItemsList;
use Nova\Menus\Models\Menu;
use Nova\Menus\Models\MenuItem;
use Nova\Menus\Spotlight;

class MenusServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'menu-items-list' => MenuItemsList::class,
        ];
    }

    public function morphMaps(): array
    {
        return [
            'menu' => Menu::class,
            'menu-item' => MenuItem::class,
        ];
    }

    public function spotlightCommands(): array
    {
        return [
            Spotlight\AddMenuItem::class,
            Spotlight\EditMenuItem::class,
            Spotlight\ViewMenuItems::class,
        ];
    }
}
