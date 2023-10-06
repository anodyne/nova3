<?php

declare(strict_types=1);

namespace Nova\Characters\Livewire;

use Livewire\Component;
use Nova\Characters\Models\Character;

class CharactersDropdown extends Component
{
    public $characters;

    public $index;

    public $search;

    public $selected;

    public function selectCharacter($characterId)
    {
        $this->dispatch('characters-dropdown-close');

        $this->selected = $this->characters->where('id', $characterId)->first();

        $this->dispatch('characterSelected', characterId: $characterId, index: $this->index);

        $this->resetCharacters();
    }

    public function updatedSearch($value)
    {
        $this->characters = Character::query()
            ->where('name', 'like', "%{$value}%")
            ->orderBy('name')
            ->get();
    }

    public function mount($character = null, $index = 0)
    {
        $this->index = $index;
        $this->resetCharacters();

        if ($character) {
            $this->selected = Character::find($character);
        }
    }

    public function render()
    {
        return view('livewire.characters.dropdown');
    }

    protected function resetCharacters()
    {
        $this->reset('search');
        $this->characters = Character::get();
    }
}
