<?php

declare(strict_types=1);

namespace Nova\Ranks\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Models\RankItem;

/**
 * @property-read Collection $rankGroups
 * @property-read ?RankItem $selectedRank
 */
class RankItemsDropdown extends Component
{
    public ?int $selected = null;

    public function mount(?int $rank = null): void
    {
        $this->selected = $rank;
    }

    public function render(): View
    {
        return view('pages.ranks.livewire.rank-items-dropdown', [
            'rankGroups' => $this->rankGroups,
            'selectedRank' => $this->selectedRank,
        ]);
    }

    #[Computed]
    public function rankGroups(): Collection
    {
        return RankGroup::with('ranks')
            ->whereHas('ranks')
            ->ordered()
            ->get();
    }

    #[Computed]
    public function selectedRank(): ?RankItem
    {
        return RankItem::find($this->selected);
    }
}
