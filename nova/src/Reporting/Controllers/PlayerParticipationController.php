<?php

declare(strict_types=1);

namespace Nova\Reporting\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Reporting\Reports\ParticipationReporter;
use Nova\Reporting\Responses\PlayerParticipationResponse;

class PlayerParticipationController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke()
    {
        $participation = ParticipationReporter::make();

        return PlayerParticipationResponse::sendWith([
            'participation' => $participation,
            'settings' => settings('posting_activity'),
        ]);
    }
}
