<?php

namespace Nova\Ranks\Http\Livewire;

use Livewire\Component;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Actions\CreateRankGroup;
use Nova\Ranks\DataTransferObjects\RankGroupData;

class RankGroupsDropdown extends Component
{
    public $groupId;

    public $groups;

    public $query;

    public $selected;

    public $selectedId;

    public function createAndSelectGroup(CreateRankGroup $action)
    {
        $newGroup = $action->execute(new RankGroupData([
            'name' => $this->query,
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

        $this->query = null;

        $this->fetchGroups();

        $this->selectedId = $groupId;
        $this->selected = $this->groups->where('id', $groupId)->first();
    }

    public function updatedQuery($value)
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
