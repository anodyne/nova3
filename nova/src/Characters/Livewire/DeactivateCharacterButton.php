<?php

declare(strict_types=1);

namespace Nova\Characters\Livewire;

use Livewire\Component;
use Nova\Characters\Actions\DeactivateCharacter;
use Nova\Characters\Models\Character;

class DeactivateCharacterButton extends Component
{
    public Character $character;

    public function deactivate(): void
    {
        DeactivateCharacter::run($this->character);

        redirect()
            ->route('characters.edit', $this->character)
            ->notify("{$this->character->name} was deactivated");
    }

    public function render()
    {
        return <<<'blade'
            <x-button.filled type="button" color="neutral" wire:click="deactivate">Deactivate</x-button.filled>
        blade;
    }
}
