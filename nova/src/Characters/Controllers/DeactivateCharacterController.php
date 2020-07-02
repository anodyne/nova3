<?php

namespace Nova\Characters\Controllers;

use Illuminate\Http\Request;
use Nova\Characters\Models\Character;
use Nova\Foundation\Controllers\Controller;
use Nova\Characters\Actions\DeactivateCharacter;
use Nova\Characters\Events\CharacterDeactivated;
use Nova\Characters\Responses\DeactivateCharacterResponse;

class DeactivateCharacterController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function confirm(Request $request)
    {
        $character = Character::findOrFail($request->id);

        return app(DeactivateCharacterResponse::class)->with([
            'character' => $character,
        ]);
    }

    public function deactivate(
        DeactivateCharacter $action,
        Character $character
    ) {
        $this->authorize('deactivate', $character);

        $character = $action->execute($character);

        CharacterDeactivated::dispatch($character);

        return redirect()
            ->route('characters.index', 'status=active')
            ->withToast("{$character->name} has been deactivated");
    }
}
