<?php

declare(strict_types=1);

namespace Nova\Pages\Providers;

use Nova\DomainServiceProvider;
use Nova\Pages\Livewire\PageDesigner;
use Nova\Pages\Livewire\PagesList;
use Nova\Pages\Models\Page;
use Nova\Roles\Spotlight\AddRole;
use Nova\Roles\Spotlight\EditRole;
use Nova\Roles\Spotlight\ViewRole;
use Nova\Roles\Spotlight\ViewRoles;

class PageServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'pages-designer' => PageDesigner::class,
            'pages-list' => PagesList::class,
        ];
    }

    public function morphMaps(): array
    {
        return [
            'page' => Page::class,
        ];
    }

    // public function spotlightCommands(): array
    // {
    //     return [
    //         AddRole::class,
    //         EditRole::class,
    //         ViewRole::class,
    //         ViewRoles::class,
    //     ];
    // }
}
