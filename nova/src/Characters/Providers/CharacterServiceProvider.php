<?php

declare(strict_types=1);

namespace Nova\Characters\Providers;

use Nova\Characters\Livewire\CharactersCollector;
use Nova\Characters\Livewire\CharactersDropdown;
use Nova\Characters\Models\Character;
use Nova\Characters\Policies\CharacterPolicy;
use Nova\Characters\Responses\CreateCharacterResponse;
use Nova\Characters\Responses\DeactivateCharacterResponse;
use Nova\Characters\Responses\DeleteCharacterResponse;
use Nova\Characters\Responses\ShowAllCharactersResponse;
use Nova\Characters\Responses\ShowCharacterResponse;
use Nova\Characters\Responses\UpdateCharacterResponse;
use Nova\Characters\Spotlight\CreateCharacter;
use Nova\Characters\Spotlight\EditCharacter;
use Nova\Characters\Spotlight\ViewCharacter;
use Nova\DomainServiceProvider;

class CharacterServiceProvider extends DomainServiceProvider
{
    protected $livewireComponents = [
        'characters:collector' => CharactersCollector::class,
        'characters:dropdown' => CharactersDropdown::class,
    ];

    protected $morphMaps = [
        'characters' => Character::class,
    ];

    protected $policies = [
        Character::class => CharacterPolicy::class,
    ];

    protected $responsables = [
        CreateCharacterResponse::class,
        DeactivateCharacterResponse::class,
        DeleteCharacterResponse::class,
        ShowAllCharactersResponse::class,
        ShowCharacterResponse::class,
        UpdateCharacterResponse::class,
    ];

    public function spotlightCommands(): array
    {
        return [
            CreateCharacter::class,
            EditCharacter::class,
            ViewCharacter::class,
        ];
    }
}
