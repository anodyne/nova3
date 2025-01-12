<?php

declare(strict_types=1);

namespace Nova\Reporting\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Reporting\Reports\GameStatsReporter;
use Nova\Reporting\Responses\GameStatsResponse;

class GameStatsController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke()
    {
        $stats = GameStatsReporter::make();

        return GameStatsResponse::sendWith([
            'stats' => $stats->stats(),
            'settings' => settings('posting_activity'),
        ]);
    }
}
