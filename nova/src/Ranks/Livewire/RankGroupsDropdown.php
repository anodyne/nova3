<?php

namespace Nova\Ranks\Livewire;

use Livewire\Component;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Actions\CreateRankGroup;
use Nova\Ranks\DataTransferObjects\RankGroupData;

class RankGroupsDropdown extends Component
{
    public $groupId;

    public $groups;

    public $search;

    public $selected;

    public $selectedId;

    public function createAndSelectGroup(CreateRankGroup $action)
    {
        $newGroup = $action->execute(new RankGroupData([
            'name' => $this->search,
        ]));

        $this->selectGroup($newGroup->id, $newGroup);
    }

    public function fetchGroups()
    {
        $this->groups = RankGroup::orderBySort()->get();
    }

    public function selectGroup($groupId)
    {
        $this->dispatchBrowserEvent('listbox-close');

        $this->reset('search');

        $this->fetchGroups();

        $this->selectedId = $groupId;
        $this->selected = $this->groups->where('id', $groupId)->first();
    }

    public function updatedSearch($value)
    {
        $this->groups = RankGroup::query()
            ->where('name', 'like', "%{$value}%")
            ->orderBySort()
            ->get();
    }

    public function mount($groupId = null)
    {
        $this->fetchGroups();

        $this->selectedId = $groupId;
        $this->selected = $groupId ? $this->groups->where('id', $groupId)->first() : null;
    }

    public function render()
    {
        return view('livewire.ranks.groups-dropdown');
    }
}
