<?php

declare(strict_types=1);

namespace Nova\PublicSite\Controllers;

use Nova\Characters\Models\Character;
use Nova\Forms\Models\Form;
use Nova\Foundation\Controllers\Controller;
use Nova\PublicSite\Responses\ShowCharacterBioResponse;

class ShowCharacterBioController extends Controller
{
    public function __invoke(Character $character)
    {
        return ShowCharacterBioResponse::sendWith([
            'character' => $character->loadMissing('positions', 'rank.name', 'characterFormSubmission'),
            'form' => Form::key('characterBio')->first(),
        ]);
    }
}
