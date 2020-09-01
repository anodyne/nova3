<?php

namespace Nova\Characters\Providers;

use Nova\DomainServiceProvider;
use Nova\Characters\Models\Character;
use Nova\Characters\Policies\CharacterPolicy;
use Nova\Characters\Livewire\CharactersDropdown;
use Nova\Characters\Livewire\CharactersCollector;
use Nova\Characters\Responses\ShowCharacterResponse;
use Nova\Characters\Responses\CreateCharacterResponse;
use Nova\Characters\Responses\DeleteCharacterResponse;
use Nova\Characters\Responses\UpdateCharacterResponse;
use Nova\Characters\Responses\ShowAllCharactersResponse;
use Nova\Characters\Responses\DeactivateCharacterResponse;

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
}
