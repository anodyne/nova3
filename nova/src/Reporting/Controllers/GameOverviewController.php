<?php

declare(strict_types=1);

namespace Nova\Reporting\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Reporting\Reports\ActivityReporter;
use Nova\Reporting\Reports\ParticipationReporter;
use Nova\Reporting\Repositories\ReportingRepositoryInterface;
use Nova\Reporting\Responses\GameOverviewResponse;

class GameOverviewController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke()
    {
        $activity = ActivityReporter::make();
        $participation = ParticipationReporter::make();

        return GameOverviewResponse::sendWith([
            'activity' => $activity,
            'participation' => $participation,
            'postingStats' => $this->getPostingStats(),
            'settings' => settings('posting_activity'),
        ]);
    }

    protected function getPostingStats()
    {
        $start = settings('posting_activity')->timeframe->startDate();
        $end = settings('posting_activity')->timeframe->endDate();

        return app(ReportingRepositoryInterface::class)
            ->getPostingStatsQuery($start, $end)
            ->first();
    }
}
