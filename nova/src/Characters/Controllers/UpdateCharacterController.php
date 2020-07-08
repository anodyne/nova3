<?php

namespace Nova\Characters\Controllers;

use Nova\Characters\Models\Character;
use Nova\Foundation\Controllers\Controller;
use Nova\Characters\Actions\UpdateCharacterManager;
use Nova\Characters\Events\CharacterUpdatedByAdmin;
use Nova\Characters\Requests\UpdateCharacterRequest;
use Nova\Characters\Responses\UpdateCharacterResponse;

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

        return app(UpdateCharacterResponse::class)->with([
            'character' => $character->load('positions', 'users'),
        ]);
    }

    public function update(
        UpdateCharacterRequest $request,
        UpdateCharacterManager $action,
        Character $character
    ) {
        $this->authorize('update', $character);

        $character = $action->execute($character, $request);

        CharacterUpdatedByAdmin::dispatch($character);

        return back()->withToast("{$character->name} was updated");
    }
}
