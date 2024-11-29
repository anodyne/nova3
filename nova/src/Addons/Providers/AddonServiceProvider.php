<?php

declare(strict_types=1);

namespace Nova\Addons\Providers;

use Nova\Addons\Actions\SetupAddonDirectory;
use Nova\Addons\Livewire\AddonSettings;
use Nova\Addons\Livewire\AddonsList;
use Nova\Addons\Models\Addon;
use Nova\Addons\Spotlight\AddAddon;
use Nova\Addons\Spotlight\EditAddon;
use Nova\Addons\Spotlight\ViewAddon;
use Nova\Addons\Spotlight\ViewAddons;
use Nova\DomainServiceProvider;

class AddonServiceProvider extends DomainServiceProvider
{
    public function consoleCommands(): array
    {
        return [
            SetupAddonDirectory::class,
        ];
    }

    public function livewireComponents(): array
    {
        return [
            'addon-settings' => AddonSettings::class,
            'addons-list' => AddonsList::class,
        ];
    }

    public function morphMaps(): array
    {
        return [
            'addon' => Addon::class,
        ];
    }

    public function prefixedIds(): array
    {
        return [
            'add_' => Addon::class,
        ];
    }

    public function spotlightCommands(): array
    {
        return [
            AddAddon::class,
            EditAddon::class,
            ViewAddon::class,
            ViewAddons::class,
        ];
    }
}
