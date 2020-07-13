<?php

namespace Nova\Ranks\Livewire;

use Livewire\Component;
use Nova\Ranks\Models\RankName;
use Nova\Ranks\Actions\CreateRankName;
use Nova\Ranks\DataTransferObjects\RankNameData;

class RankNamesDropdown extends Component
{
    public $nameId;

    public $names;

    public $query;

    public $selected;

    public $selectedId;

    public function createAndSelectName(CreateRankName $action)
    {
        $newName = $action->execute(new RankNameData([
            'name' => $this->query,
        ]));

        $this->selectName($newName->id, $newName);
    }

    public function fetchNames()
    {
        $this->names = RankName::orderBySort()->get();
    }

    public function selectName($nameId)
    {
        $this->dispatchBrowserEvent('listbox-close');

        $this->query = null;

        $this->fetchNames();

        $this->selectedId = $nameId;
        $this->selected = $this->names->where('id', $nameId)->first();
    }

    public function updatedQuery($value)
    {
        $this->names = RankName::query()
            ->where('name', 'like', "%{$value}%")
            ->orderBySort()
            ->get();
    }

    public function mount($nameId = null)
    {
        $this->fetchNames();

        $this->selectedId = $nameId;
        $this->selected = $nameId ? $this->names->where('id', $nameId)->first() : null;
    }

    public function render()
    {
        return view('livewire.ranks.names-dropdown');
    }
}
