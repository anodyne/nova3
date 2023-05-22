<?php

declare(strict_types=1);

namespace Nova\Ranks\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Nova\Ranks\Actions\CreateRankGroup;
use Nova\Ranks\Data\RankGroupData;
use Nova\Ranks\Models\RankGroup;

class RankGroupsDropdown extends Component
{
    public $groupId;

    public $search;

    public $selected;

    public $selectedId;

    public function createAndSelectGroup()
    {
        $group = CreateRankGroup::run(RankGroupData::from([
            'name' => $this->search,
        ]));

        $this->selectGroup($group->id, $group);
    }

    public function selectGroup($groupId)
    {
        $this->dispatchBrowserEvent('rank-groups-dropdown-close');

        $this->reset('search');

        $this->selectedId = $groupId;
        $this->selected = $this->filteredGroups->where('id', $groupId)->first();
    }

    public function getFilteredGroupsProperty(): Collection
    {
        return RankGroup::query()
            ->when($this->search, fn ($query, $value) => $query->searchFor($value))
            ->ordered()
            ->get();
    }

    public function mount($groupId = null)
    {
        $this->selectedId = $groupId;
        $this->selected = $groupId ? $this->filteredGroups->where('id', $groupId)->first() : null;
    }

    public function render()
    {
        return view('livewire.ranks.groups-dropdown', [
            'filteredGroups' => $this->filteredGroups,
        ]);
    }
}
