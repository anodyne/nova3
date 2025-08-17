<?php

declare(strict_types=1);

namespace Nova\Ranks\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Ranks\Models\RankGroup;

class RankGroupsDropdown extends Component
{
    public ?int $group = null;

    public function render(): View
    {
        return view('pages.ranks.livewire.rank-groups-dropdown', [
            'rankGroups' => $this->rankGroups,
        ]);
    }

    #[Computed]
    public function rankGroups(): Collection
    {
        return RankGroup::query()
            ->ordered()
            ->get();
    }
}
