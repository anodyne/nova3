<?php

declare(strict_types=1);

namespace Nova\Characters\Providers;

use Nova\Characters\Livewire\CharactersCollector;
use Nova\Characters\Livewire\CharactersDropdown;
use Nova\Characters\Livewire\CharactersList;
use Nova\Characters\Livewire\SelectCharactersModal;
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
            'characters:collector' => CharactersCollector::class,
            'characters:dropdown' => CharactersDropdown::class,
            'characters:list' => CharactersList::class,
            'characters:select-characters-modal' => SelectCharactersModal::class,
        ];
    }

    public function morphMaps(): array
    {
        return [
            'character' => Character::class,
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
