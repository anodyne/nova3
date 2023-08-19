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
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankName;

class RankServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'rank-groups-dropdown' => RankGroupsDropdown::class,
            'rank-groups-list' => RankGroupsList::class,
            'rank-items-dropdown' => RankItemsDropdown::class,
            'rank-items-list' => RankItemsList::class,
            'rank-names-dropdown' => RankNamesDropdown::class,
            'rank-names-list' => RankNamesList::class,
        ];
    }

    public function morphMaps(): array
    {
        return [
            'rank-group' => RankGroup::class,
            'rank-item' => RankItem::class,
            'rank-name' => RankName::class,
        ];
    }
}
