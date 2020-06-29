<?php

namespace Nova\Characters\Http\Controllers;

use Nova\Users\Models\User;
use Illuminate\Http\Request;
use Nova\Characters\Models\Character;
use Nova\Characters\Filters\CharacterFilters;
use Nova\Users\Http\Responses\ShowUserResponse;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Characters\Http\Responses\ShowAllCharactersResponse;
use Nova\Characters\Http\Responses\ShowCharacterResponse;

class ShowCharacterController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function all(Request $request, CharacterFilters $filters)
    {
        $this->authorize('viewAny', Character::class);

        $characters = Character::with('media', 'positions', 'rank.name', 'users')
            ->filter($filters)
            ->orderBy('name')
            ->paginate();

        return app(ShowAllCharactersResponse::class)->with([
            'search' => $request->search,
            'characters' => $characters,
        ]);
    }

    public function show(Character $character)
    {
        $this->authorize('view', $character);

        return app(ShowCharacterResponse::class)->with([
            'character' => $character->load('positions', 'rank.name', 'users'),
        ]);
    }
}
