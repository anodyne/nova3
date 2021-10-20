<?php

declare(strict_types=1);

namespace Nova\Ranks\Providers;

use Nova\DomainServiceProvider;
use Nova\Ranks\Livewire\RankGroupsDropdown;
use Nova\Ranks\Livewire\RankItemsDropdown;
use Nova\Ranks\Livewire\RankNamesDropdown;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankName;
use Nova\Ranks\Policies\RankGroupPolicy;
use Nova\Ranks\Policies\RankItemPolicy;
use Nova\Ranks\Policies\RankNamePolicy;

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

    public function policies(): array
    {
        return [
            RankGroup::class => RankGroupPolicy::class,
            RankItem::class => RankItemPolicy::class,
            RankName::class => RankNamePolicy::class,
        ];
    }
}
