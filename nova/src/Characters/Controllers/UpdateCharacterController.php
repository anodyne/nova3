<?php

declare(strict_types=1);

namespace Nova\Characters\Controllers;

use Nova\Characters\Actions\UpdateCharacterManager;
use Nova\Characters\Events\CharacterUpdatedByAdmin;
use Nova\Characters\Models\Character;
use Nova\Characters\Requests\UpdateCharacterRequest;
use Nova\Characters\Responses\UpdateCharacterResponse;
use Nova\Foundation\Controllers\Controller;

class UpdateCharacterController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function edit(Character $character)
    {
        $this->authorize('update', $character);

        return UpdateCharacterResponse::sendWith([
            'character' => $character->load('positions', 'users'),
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
