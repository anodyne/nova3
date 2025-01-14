<?php

declare(strict_types=1);

namespace Nova\Reporting\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Date;
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

        $settings = settings('posting_activity');

        $timeframes = [
            'lastMonth' => Date::now()->subMonth()->format('F Y'),
            'thisMonth' => Date::now()->format('F Y'),
            'lifetime' => 'Lifetime',
        ];

        if (! $settings->isMonthlyTimeframe()) {
            $timeframes = Arr::prepend($timeframes, $settings->timeframe->getStatsLabel(), 'currentTimeframe');
        }

        return GameStatsResponse::sendWith([
            'stats' => $stats->stats(),
            'timeframes' => $timeframes,
            'settings' => $settings,
        ]);
    }
}
