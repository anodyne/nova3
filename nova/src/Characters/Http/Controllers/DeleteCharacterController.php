<?php

namespace Nova\Characters\Http\Controllers;

use Illuminate\Http\Request;
use Nova\Characters\Models\Character;
use Nova\Characters\Actions\DeleteCharacter;
use Nova\Foundation\Http\Controllers\Controller;
use Nova\Characters\Events\CharacterDeletedByAdmin;
use Nova\Characters\Http\Responses\DeleteCharacterResponse;

class DeleteCharacterController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function confirm(Request $request)
    {
        $character = Character::findOrFail($request->id);

        return app(DeleteCharacterResponse::class)->with([
            'character' => $character,
        ]);
    }

    public function destroy(DeleteCharacter $action, Character $character)
    {
        $this->authorize('delete', $character);

        $character = $action->execute($character);

        event(new CharacterDeletedByAdmin($character));

        return redirect()
            ->route('characters.index')
            ->withToast("{$character->name}'s account was deleted");
    }
}
