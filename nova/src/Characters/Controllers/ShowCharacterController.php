<?php

namespace Nova\Characters\Controllers;

use Illuminate\Http\Request;
use Nova\Characters\Models\Character;
use Nova\Foundation\Controllers\Controller;
use Nova\Characters\Filters\CharacterFilters;
use Nova\Characters\Responses\ShowCharacterResponse;
use Nova\Characters\Responses\ShowAllCharactersResponse;

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
            'character' => $character->load('media', 'positions', 'rank.name', 'users'),
        ]);
    }
}
