<?php

declare(strict_types=1);

namespace Nova\Characters\Providers;

use Nova\Characters\Livewire\ActivateCharacterButton;
use Nova\Characters\Livewire\CharactersList;
use Nova\Characters\Livewire\DeactivateCharacterButton;
use Nova\Characters\Livewire\ManageOwnership;
use Nova\Characters\Livewire\ManagePositions;
use Nova\Characters\Livewire\ManageUsers;
use Nova\Characters\Models\Character;
use Nova\Characters\Spotlight\AddCharacter;
use Nova\Characters\Spotlight\EditCharacter;
use Nova\Characters\Spotlight\ViewCharacter;
use Nova\DomainServiceProvider;

class CharacterServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'characters-list' => CharactersList::class,
            'characters-manage-ownership' => ManageOwnership::class,
            'characters-manage-positions' => ManagePositions::class,
            'characters-manage-users' => ManageUsers::class,
            'characters-activate-button' => ActivateCharacterButton::class,
            'characters-deactivate-button' => DeactivateCharacterButton::class,
        ];
    }

    public function morphMaps(): array
    {
        return [
            'character' => Character::class,
        ];
    }

    public function prefixedIds(): array
    {
        return [
            'char_' => Character::class,
        ];
    }

    public function spotlightCommands(): array
    {
        return [
            AddCharacter::class,
            EditCharacter::class,
            ViewCharacter::class,
        ];
    }
}
