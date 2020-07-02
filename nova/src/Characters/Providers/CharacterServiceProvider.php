<?php

namespace Nova\Characters\Providers;

use Nova\DomainServiceProvider;
use Nova\Characters\Models\Character;
use Nova\Characters\Policies\CharacterPolicy;
use Nova\Characters\Livewire\CharacterUploadAvatar;
use Nova\Characters\Responses\ShowCharacterResponse;
use Nova\Characters\Responses\CreateCharacterResponse;
use Nova\Characters\Responses\ShowAllCharactersResponse;

class CharacterServiceProvider extends DomainServiceProvider
{
    protected $livewireComponents = [
        'characters:upload-avatar' => CharacterUploadAvatar::class,
    ];

    protected $morphMaps = [
        'characters' => Character::class,
    ];

    protected $policies = [
        Character::class => CharacterPolicy::class,
    ];

    protected $responsables = [
        CreateCharacterResponse::class,
        ShowAllCharactersResponse::class,
        ShowCharacterResponse::class,
    ];
}
