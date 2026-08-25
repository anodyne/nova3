<?php

declare(strict_types=1);

namespace Nova\Ranks\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Ranks\Models\RankGroup;

/**
 * @property-read Collection<int, RankGroup> $rankGroups
 */
class RankGroupsDropdown extends Component
{
    public ?int $group = null;

    public function render(): View
    {
        return view('pages.ranks.livewire.rank-groups-dropdown', [
            'rankGroups' => $this->rankGroups,
        ]);
    }

    /** @return Collection<int, RankGroup> */
    #[Computed]
    public function rankGroups(): Collection
    {
        return RankGroup::query()
            ->ordered()
            ->get();
    }
}
