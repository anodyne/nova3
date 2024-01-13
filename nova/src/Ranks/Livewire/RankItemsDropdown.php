<?php

declare(strict_types=1);

namespace Nova\Ranks\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Models\RankItem;

class RankItemsDropdown extends Component
{
    public ?Collection $groups = null;

    public ?Collection $items = null;

    public ?RankItem $selected = null;

    public function clearRankItems(): void
    {
        $this->items = null;
    }

    public function selectRankGroup(int $groupId): void
    {
        $this->items = RankItem::query()
            ->active()
            ->group($groupId)
            ->ordered()
            ->get();
    }

    public function selectRankItem($rankId): void
    {
        $this->dispatch('dropdown-close');

        $this->selected = $this->items?->where('id', $rankId)->first();
    }

    public function mount(?int $rank = null): void
    {
        $this->groups = RankGroup::ordered()->get();

        if ($rank) {
            $this->selected = RankItem::find($rank);

            $this->selectRankGroup($this->selected->group_id);
        }
    }

    public function render(): View
    {
        return view('pages.ranks.livewire.rank-items-dropdown');
    }
}
