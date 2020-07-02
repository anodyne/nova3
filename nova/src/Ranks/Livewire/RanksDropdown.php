<?php

namespace Nova\Ranks\Livewire;

use Livewire\Component;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankGroup;

class RanksDropdown extends Component
{
    public $groupId;

    public $groups;

    public $rankId;

    public $ranks;

    public $selectedRank;

    public function updatedGroupId($value)
    {
        $this->ranks = RankItem::whereGroup($value)
            ->orderBySort()
            ->get();
    }

    public function updatedRankId($value)
    {
        $this->selectedRank = $this->ranks->where('id', $value)->first();
    }

    public function mount()
    {
        $this->groups = RankGroup::orderBySort()->get();
    }

    public function render()
    {
        return view('livewire.ranks.dropdown');
    }
}
