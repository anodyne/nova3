<?php

declare(strict_types=1);

namespace Nova\Characters\Livewire;

use Livewire\Component;
use Nova\Characters\Actions\ActivateCharacter;
use Nova\Characters\Models\Character;

class ActivateCharacterButton extends Component
{
    public Character $character;

    public function activate(): void
    {
        ActivateCharacter::run($this->character);

        redirect()
            ->route('characters.edit', $this->character)
            ->notify("{$this->character->name} was activated");
    }

    public function render()
    {
        return <<<'blade'
            <x-button.filled type="button" color="neutral" wire:click="activate">Activate</x-button.filled>
        blade;
    }
}
