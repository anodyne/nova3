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
    public ?Collection $groups;

    public ?Collection $items;

    public ?RankItem $selected;

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
        $this->dispatchBrowserEvent('rank-items-dropdown-close');

        $this->selected = $this->items?->where('id', $rankId)->first();
    }

    public function mount(int $rank = null): void
    {
        $this->groups = RankGroup::ordered()->get();

        if ($rank) {
            $this->selected = RankItem::find($rank);

            $this->selectRankGroup($this->selected->group_id);
        }
    }

    public function render(): View
    {
        return view('livewire.ranks.rank-items-dropdown');
    }
}
