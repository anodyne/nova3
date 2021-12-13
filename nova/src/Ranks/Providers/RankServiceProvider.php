<?php

declare(strict_types=1);

namespace Nova\Ranks\Providers;

use Nova\DomainServiceProvider;
use Nova\Ranks\Livewire\RankGroupsDropdown;
use Nova\Ranks\Livewire\RankItemsDropdown;
use Nova\Ranks\Livewire\RankNamesDropdown;

class RankServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'ranks:items-dropdown' => RankItemsDropdown::class,
            'ranks:groups-dropdown' => RankGroupsDropdown::class,
            'ranks:names-dropdown' => RankNamesDropdown::class,
        ];
    }
}
