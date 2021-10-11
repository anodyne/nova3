<?php

declare(strict_types=1);

namespace Nova\Characters\Controllers;

use Nova\Characters\Actions\CreateCharacterManager;
use Nova\Characters\Events\CharacterCreatedByAdmin;
use Nova\Characters\Models\Character;
use Nova\Characters\Requests\CreateCharacterRequest;
use Nova\Characters\Responses\CreateCharacterResponse;
use Nova\Foundation\Controllers\Controller;

class CreateCharacterController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function create()
    {
        $this->authorize('createAny', Character::class);

        return app(CreateCharacterResponse::class);
    }

    public function store(CreateCharacterRequest $request)
    {
        $this->authorize('createAny', Character::class);

        $character = CreateCharacterManager::run($request);

        CharacterCreatedByAdmin::dispatchIf(
            $request->user()->can('create', Character::class),
            $character
        );

        return redirect()
            ->route('characters.index', 'status=active')
            ->withToast("{$character->name} was created");
    }
}
