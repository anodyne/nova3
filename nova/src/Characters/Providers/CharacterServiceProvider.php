<?php

namespace Nova\Characters\Providers;

use Nova\DomainServiceProvider;
use Nova\Characters\Models\Character;
use Nova\Characters\Policies\CharacterPolicy;
use Nova\Characters\Http\Responses\ShowAllCharactersResponse;

class CharacterServiceProvider extends DomainServiceProvider
{
    protected $morphMaps = [
        'characters' => Character::class,
    ];

    protected $policies = [
        Character::class => CharacterPolicy::class,
    ];

    protected $responsables = [
        ShowAllCharactersResponse::class,
    ];
}
