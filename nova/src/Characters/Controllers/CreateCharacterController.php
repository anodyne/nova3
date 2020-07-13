<?php

namespace Nova\Characters\Controllers;

use Nova\Characters\Models\Character;
use Nova\Foundation\Controllers\Controller;
use Nova\Characters\Actions\CreateCharacterManager;
use Nova\Characters\Events\CharacterCreatedByAdmin;
use Nova\Characters\Requests\CreateCharacterRequest;
use Nova\Characters\Responses\CreateCharacterResponse;

class CreateCharacterController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function create()
    {
        $this->authorize('create', Character::class);

        return app(CreateCharacterResponse::class);
    }

    public function store(
        CreateCharacterRequest $request,
        CreateCharacterManager $action
    ) {
        $this->authorize('create', Character::class);

        $character = $action->execute($request);

        CharacterCreatedByAdmin::dispatch($character);

        return redirect()
            ->route('characters.index', 'status=active')
            ->withToast("{$character->name} was created");
    }
}
