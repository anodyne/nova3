<?php

declare(strict_types=1);

namespace Nova\Reporting\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Foundation\Responses\Responsable;
use Nova\Reporting\Reports\ActivityReporter;
use Nova\Reporting\Reports\ParticipationReporter;
use Nova\Reporting\Repositories\ReportingRepositoryInterface;
use Nova\Reporting\Responses\GameOverviewResponse;
use stdClass;

class GameOverviewController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(): Responsable
    {
        $activityReporter = ActivityReporter::make();
        $participationReporter = ParticipationReporter::make();

        return GameOverviewResponse::sendWith([
            'activity' => $activityReporter,
            'participation' => $participationReporter,
            'postingStats' => $this->getPostingStats(),
            'settings' => settings('posting_activity'),
        ]);
    }

    protected function getPostingStats(): ?stdClass
    {
        $start = settings('posting_activity')->timeframe->startDate();
        $end = settings('posting_activity')->timeframe->endDate();

        return app(ReportingRepositoryInterface::class)
            ->getPostingStatsQuery($start, $end)
            ->first();
    }
}
