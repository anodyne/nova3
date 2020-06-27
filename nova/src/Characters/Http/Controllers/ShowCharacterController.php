<?php

namespace Nova\Characters\Http\Controllers;

use Nova\Users\Models\User;
use Illuminate\Http\Request;
use Nova\Characters\Models\Character;
use Nova\Characters\Filters\CharacterFilters;
use Nova\Users\Http\Responses\ShowUserResponse;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Characters\Http\Responses\ShowAllCharactersResponse;

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

        $characters = Character::with('media')
            ->withAssignedUser()
            ->filter($filters)
            ->orderBy('name')
            ->paginate();

        return app(ShowAllCharactersResponse::class)->with([
            'search' => $request->search,
            'characters' => $characters,
        ]);
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);

        return app(ShowUserResponse::class)->with([
            'user' => $user->load('roles', 'logins'),
        ]);
    }
}
