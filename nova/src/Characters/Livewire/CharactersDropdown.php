<?php

namespace Nova\Characters\Livewire;

use Livewire\Component;
use Nova\Characters\Models\Character;

class CharactersDropdown extends Component
{
    public $index;

    public $query;

    public $selected;

    public $characters;

    public function selectCharacter($characterId)
    {
        $this->dispatchBrowserEvent('characters-dropdown-close');

        $this->selected = $this->characters->where('id', $characterId)->first();

        $this->emitUp('characterSelected', $characterId, $this->index);
    }

    public function updatedQuery($value)
    {
        $this->characters = Character::query()
            ->where('name', 'like', "%{$value}%")
            ->orderBy('name')
            ->get();
    }

    public function mount($character = null, $index = 0)
    {
        $this->index = $index;
        $this->characters = Character::get();

        if ($character) {
            $this->selected = Character::find($character);
        }
    }

    public function render()
    {
        return view('livewire.characters.dropdown');
    }
}
