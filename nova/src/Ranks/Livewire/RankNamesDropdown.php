<?php

declare(strict_types=1);

namespace Nova\Ranks\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Nova\Ranks\Actions\CreateRankName;
use Nova\Ranks\Data\RankNameData;
use Nova\Ranks\Models\RankName;

class RankNamesDropdown extends Component
{
    public $nameId;

    public $search;

    public $selected;

    public $selectedId;

    public function createAndSelectName()
    {
        $name = CreateRankName::run(RankNameData::from([
            'name' => $this->search,
        ]));

        $this->selectName($name->id, $name);
    }

    public function selectName($nameId)
    {
        $this->dispatchBrowserEvent('rank-names-dropdown-close');

        $this->reset('search');

        $this->selectedId = $nameId;
        $this->selected = $this->filteredNames->where('id', $nameId)->first();
    }

    public function getFilteredNamesProperty(): Collection
    {
        return RankName::query()
            ->when($this->search, fn ($query, $value) => $query->searchFor($value))
            ->ordered()
            ->get();
    }

    public function mount($nameId = null)
    {
        $this->selectedId = $nameId;
        $this->selected = $nameId ? $this->filteredNames->where('id', $nameId)->first() : null;
    }

    public function render()
    {
        return view('livewire.ranks.names-dropdown', [
            'filteredNames' => $this->filteredNames,
        ]);
    }
}
