<?php

declare(strict_types=1);

namespace Nova\Ranks\Providers;

use Nova\DomainServiceProvider;
use Nova\Ranks\Livewire\RankGroupsDropdown;
use Nova\Ranks\Livewire\RankGroupsList;
use Nova\Ranks\Livewire\RankItemsDropdown;
use Nova\Ranks\Livewire\RankItemsList;
use Nova\Ranks\Livewire\RankNamesDropdown;
use Nova\Ranks\Livewire\RankNamesList;

class RankServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'rank-groups:list' => RankGroupsList::class,
            'rank-items:list' => RankItemsList::class,
            'rank-names:list' => RankNamesList::class,
            'ranks:items-dropdown' => RankItemsDropdown::class,
            'ranks:groups-dropdown' => RankGroupsDropdown::class,
            'ranks:names-dropdown' => RankNamesDropdown::class,
        ];
    }
}
