<?php

declare(strict_types=1);

namespace Nova\Menus\Providers;

use Nova\DomainServiceProvider;
use Nova\Foundation\Events\ModelOrderChanged;
use Nova\Menus\Listeners\RecacheAfterReordering;
use Nova\Menus\Livewire\MenuItemsList;
use Nova\Menus\Models\Menu;
use Nova\Menus\Models\MenuItem;
use Nova\Menus\Spotlight\AddMenuItem;
use Nova\Menus\Spotlight\EditMenuItem;
use Nova\Menus\Spotlight\ViewMenuItems;

class MenusServiceProvider extends DomainServiceProvider
{
    public function eventListeners(): array
    {
        return [
            ModelOrderChanged::class => [
                RecacheAfterReordering::class,
            ],
        ];
    }

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
            AddMenuItem::class,
            EditMenuItem::class,
            ViewMenuItems::class,
        ];
    }
}
