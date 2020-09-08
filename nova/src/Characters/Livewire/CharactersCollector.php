<?php

namespace Nova\Characters\Livewire;

use Livewire\Component;

class CharactersCollector extends Component
{
    public $characterIds;

    public $characters;

    protected $listeners = ['characterSelected' => 'handleCharacterSelected'];

    public function addCharacter($index)
    {
        $newIndex = $index + 1;

        $this->characters[$newIndex] = [
            'id' => null,
            'primary' => false,
        ];
    }

    public function handleCharacterSelected($characterId, $index)
    {
        $this->characters[$index] = [
            'id' => $characterId,
            'primary' => false,
        ];

        $this->updateCharacterIds();
    }

    public function removeCharacter($index)
    {
        unset($this->characters[$index]);

        $this->characters = array_values($this->characters);

        $this->updateCharacterIds();
    }

    public function updateCharacterIds()
    {
        $this->characterIds = collect($this->characters)
            ->filter(function ($character) {
                return $character['id'] !== null;
            })
            ->implode('id', ',');
    }

    public function mount($characters = null, $user = null)
    {
        if ($characters === null) {
            $this->characters[0] = [
                'id' => null,
                'primary' => false,
            ];
        } else {
            $this->characters = collect(explode(',', $characters))
                ->map(function ($character) use ($user) {
                    return [
                        'id' => $character,
                        'primary' => ($user === null)
                            ? false
                            : $user->primaryCharacter->where('id', $character)->count() > 0,
                    ];
                })
                ->toArray();

            $this->updateCharacterIds();
        }
    }

    public function render()
    {
        return view('livewire.characters.collector');
    }
}
