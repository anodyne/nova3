<?php

declare(strict_types=1);

namespace Nova\Characters\Controllers;

use Illuminate\Http\Request;
use Nova\Characters\Filters\CharacterFilters;
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

    public function all(Request $request, CharacterFilters $filters)
    {
        $characters = Character::query()
            ->with('media', 'positions', 'rank.name', 'users')
            ->when($request->user()->cannot('viewAny', Character::class), function ($query) use ($request) {
                return $query->whereRelation('users', 'users.id', '=', $request->user()->id);
            })
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
