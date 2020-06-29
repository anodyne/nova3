<?php

namespace Nova\Characters\Http\Controllers;

use Nova\Characters\Models\Character;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Characters\Actions\UpdateCharacterManager;
use Nova\Characters\Events\CharacterUpdatedByAdmin;
use Nova\Characters\Http\Requests\UpdateCharacterRequest;
use Nova\Characters\Http\Responses\UpdateCharacterResponse;

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
            'character' => $character,
        ]);
    }

    public function update(
        UpdateCharacterRequest $request,
        UpdateCharacterManager $action,
        Character $character
    ) {
        $this->authorize('update', $character);

        $character = $action->execute($character, $request);

        event(new CharacterUpdatedByAdmin($character));

        return back()->withToast("{$character->name}'s account was updated");
    }
}
