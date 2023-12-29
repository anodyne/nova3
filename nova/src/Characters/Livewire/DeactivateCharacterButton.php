<?php

declare(strict_types=1);

namespace Nova\Characters\Livewire;

use Livewire\Component;
use Nova\Characters\Actions\DeactivateCharacter;
use Nova\Characters\Events\CharacterDeactivated;
use Nova\Characters\Models\Character;

class DeactivateCharacterButton extends Component
{
    public Character $character;

    public function deactivate(): void
    {
        $this->authorize('deactivate', $this->character);

        DeactivateCharacter::run($this->character);

        CharacterDeactivated::dispatch($this->character);

        redirect()
            ->route('characters.edit', $this->character)
            ->notify("{$this->character->name} was deactivated");
    }

    public function render()
    {
        return <<<'blade'
            <x-button type="button" color="neutral" wire:click="deactivate">Deactivate</x-button>
        blade;
    }
}
