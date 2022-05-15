<?php

declare(strict_types=1);

namespace Nova\Ranks\Livewire;

use Livewire\Component;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Models\RankItem;

class RankItemsDropdown extends Component
{
    public $groups;

    public $items;

    public $selected;

    public function clearRankItems()
    {
        $this->items = null;
    }

    public function selectRankGroup($groupId)
    {
        $this->items = RankItem::query()
            ->whereActive()
            ->whereGroup($groupId)
            ->orderBySort()
            ->get();
    }

    public function selectRankItem($rankId)
    {
        $this->dispatchBrowserEvent('rank-items-dropdown-close');

        $this->selected = $this->items->where('id', $rankId)->first();
    }

    public function mount($rank = null)
    {
        $this->groups = RankGroup::orderBySort()->get();

        if ($rank) {
            $this->selected = RankItem::find($rank);

            $this->selectRankGroup($this->selected->group_id);
        }
    }

    public function render()
    {
        return view('livewire.ranks.items-dropdown');
    }
}
