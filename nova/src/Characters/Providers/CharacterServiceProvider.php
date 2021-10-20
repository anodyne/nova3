<?php

declare(strict_types=1);

namespace Nova\Characters\Providers;

use Nova\Characters\Livewire\CharactersCollector;
use Nova\Characters\Livewire\CharactersDropdown;
use Nova\Characters\Livewire\SelectCharactersModal;
use Nova\Characters\Models\Character;
use Nova\Characters\Policies\CharacterPolicy;
use Nova\Characters\Spotlight\CreateCharacter;
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
            'characters:select-characters-modal' => SelectCharactersModal::class,
        ];
    }

    public function morphMaps(): array
    {
        return [
            'character' => Character::class,
        ];
    }

    public function policies(): array
    {
        return [
            Character::class => CharacterPolicy::class,
        ];
    }

    public function spotlightCommands(): array
    {
        return [
            CreateCharacter::class,
            EditCharacter::class,
            ViewCharacter::class,
        ];
    }
}
