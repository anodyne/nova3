<?php

declare(strict_types=1);

namespace Nova\Characters\Livewire;

use Livewire\Component;
use Nova\Characters\Actions\ActivateCharacter;
use Nova\Characters\Events\CharacterActivated;
use Nova\Characters\Models\Character;

class ActivateCharacterButton extends Component
{
    public Character $character;

    public function activate(): void
    {
        $this->authorize('activate', $this->character);

        ActivateCharacter::run($this->character);

        CharacterActivated::dispatch($this->character);

        redirect()
            ->route('characters.edit', $this->character)
            ->notify("{$this->character->name} was activated");
    }

    public function render()
    {
        return <<<'blade'
            <x-button type="button" color="neutral" wire:click="activate">Activate</x-button>
        blade;
    }
}
