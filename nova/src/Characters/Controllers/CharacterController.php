<?php

declare(strict_types=1);

namespace Nova\Characters\Controllers;

use Nova\Characters\Actions\CreateCharacterManager;
use Nova\Characters\Actions\UpdateCharacterManager;
use Nova\Characters\Events\CharacterCreatedByAdmin;
use Nova\Characters\Events\CharacterUpdatedByAdmin;
use Nova\Characters\Models\Character;
use Nova\Characters\Requests\StoreCharacterRequest;
use Nova\Characters\Requests\UpdateCharacterRequest;
use Nova\Characters\Responses\CreateCharacterResponse;
use Nova\Characters\Responses\EditCharacterResponse;
use Nova\Characters\Responses\ListCharactersResponse;
use Nova\Characters\Responses\ShowCharacterResponse;
use Nova\Foundation\Controllers\Controller;

class CharacterController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function index()
    {
        return ListCharactersResponse::send();
    }

    public function show(Character $character)
    {
        $this->authorize('view', $character);

        return ShowCharacterResponse::sendWith([
            'character' => $character->load('media', 'positions', 'rank.name', 'users'),
        ]);
    }

    public function create()
    {
        $this->authorize('createAny', Character::class);

        return CreateCharacterResponse::send();
    }

    public function store(StoreCharacterRequest $request)
    {
        $this->authorize('createAny', Character::class);

        $character = CreateCharacterManager::run($request);

        CharacterCreatedByAdmin::dispatchIf(
            $request->user()->can('create', Character::class),
            $character
        );

        return redirect()
            ->route('characters.index')
            ->withToast("{$character->name} was created");
    }

    public function edit(Character $character)
    {
        $this->authorize('update', $character);

        return EditCharacterResponse::sendWith([
            'character' => $character->load('media', 'positions', 'users'),
        ]);
    }

    public function update(
        UpdateCharacterRequest $request,
        Character $character
    ) {
        $this->authorize('update', $character);

        $character = UpdateCharacterManager::run($character, $request);

        CharacterUpdatedByAdmin::dispatch($character);

        return back()->withToast("{$character->name} was updated");
    }
}
