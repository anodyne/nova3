<?php

declare(strict_types=1);

namespace Nova\Characters\Controllers;

use Nova\Characters\Models\Character;
use Nova\Characters\Responses\MigrateCharacterRanksResponse;
use Nova\Foundation\Controllers\Controller;

class MigrateCharacterRanksController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke()
    {
        $this->authorize('updateAny', Character::class);

        return MigrateCharacterRanksResponse::sendWith([
            'characters' => Character::with('positions')->paginate(15),
        ]);
    }
}
