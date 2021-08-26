<?php

declare(strict_types=1);

namespace Nova\Characters\Controllers;

use Nova\Characters\Actions\ActivateCharacter;
use Nova\Characters\Events\CharacterActivated;
use Nova\Characters\Models\Character;
use Nova\Foundation\Controllers\Controller;

class ActivateCharacterController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(ActivateCharacter $action, Character $character)
    {
        $this->authorize('activate', $character);

        $character = $action->execute($character);

        CharacterActivated::dispatch($character);

        return redirect()
            ->route('characters.index', 'status=active')
            ->withToast("{$character->name} has been activated");
    }
}
