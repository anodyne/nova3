<?php

declare(strict_types=1);

namespace Nova\Characters\Controllers;

use Illuminate\Http\Request;
use Nova\Characters\Actions\DeactivateCharacter;
use Nova\Characters\Events\CharacterDeactivated;
use Nova\Characters\Models\Character;
use Nova\Characters\Responses\DeactivateCharacterResponse;
use Nova\Foundation\Controllers\Controller;

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

        return DeactivateCharacterResponse::sendWith([
            'character' => $character,
        ]);
    }

    public function deactivate(Character $character)
    {
        $this->authorize('deactivate', $character);

        $character = DeactivateCharacter::run($character);

        CharacterDeactivated::dispatch($character);

        return redirect()
            ->route('characters.index', 'status=active')
            ->withToast("{$character->name} has been deactivated");
    }
}
