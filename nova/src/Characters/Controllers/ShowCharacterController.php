<?php

declare(strict_types=1);

namespace Nova\Characters\Controllers;

use Nova\Characters\Models\Character;
use Nova\Characters\Responses\ShowAllCharactersResponse;
use Nova\Characters\Responses\ShowCharacterResponse;
use Nova\Foundation\Controllers\Controller;

class ShowCharacterController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function all()
    {
        return ShowAllCharactersResponse::send();
    }

    public function show(Character $character)
    {
        $this->authorize('view', $character);

        return ShowCharacterResponse::sendWith([
            'character' => $character->load('media', 'positions', 'rank.name', 'users'),
        ]);
    }
}
