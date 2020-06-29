<?php

namespace Nova\Characters\Providers;

use Nova\Characters\Http\Livewire\CharacterUploadAvatar;
use Nova\Characters\Http\Responses\CreateCharacterResponse;
use Nova\DomainServiceProvider;
use Nova\Characters\Models\Character;
use Nova\Characters\Policies\CharacterPolicy;
use Nova\Characters\Http\Responses\ShowAllCharactersResponse;
use Nova\Characters\Http\Responses\ShowCharacterResponse;

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
