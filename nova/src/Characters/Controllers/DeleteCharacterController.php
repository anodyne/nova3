<?php

namespace Nova\Characters\Controllers;

use Illuminate\Http\Request;
use Nova\Characters\Models\Character;
use Nova\Foundation\Controllers\Controller;
use Nova\Characters\Actions\DeleteCharacter;
use Nova\Characters\Events\CharacterDeletedByAdmin;
use Nova\Characters\Responses\DeleteCharacterResponse;

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

        CharacterDeletedByAdmin::dispatch($character);

        return redirect()
            ->route('characters.index')
            ->withToast("{$character->name} was deleted");
    }
}
