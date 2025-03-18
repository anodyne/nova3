<?php

declare(strict_types=1);

namespace Nova\Reporting\Repositories;

use Carbon\CarbonInterface;
use Illuminate\Contracts\Database\Query\Builder;

interface ReportingRepositoryInterface
{
    public function getActivityQuery(?CarbonInterface $start, ?CarbonInterface $end): Builder;

    public function getApplicationStatsQuery(
        CarbonInterface $startOfLastMonth,
        CarbonInterface $endOfLastMonth,
        CarbonInterface $startOfThisMonth,
        CarbonInterface $endOfThisMonth,
        CarbonInterface $startOfTimeframe,
        CarbonInterface $endOfTimeframe
    ): Builder;

    public function getCharacterStatsQuery(
        CarbonInterface $startOfLastMonth,
        CarbonInterface $endOfLastMonth,
        CarbonInterface $startOfThisMonth,
        CarbonInterface $endOfThisMonth,
        CarbonInterface $startOfTimeframe,
        CarbonInterface $endOfTimeframe
    ): Builder;

    public function getPostStatsQuery(
        CarbonInterface $startOfLastMonth,
        CarbonInterface $endOfLastMonth,
        CarbonInterface $startOfThisMonth,
        CarbonInterface $endOfThisMonth,
        CarbonInterface $startOfTimeframe,
        CarbonInterface $endOfTimeframe
    ): Builder;

    public function getStoryStatsQuery(
        CarbonInterface $startOfLastMonth,
        CarbonInterface $endOfLastMonth,
        CarbonInterface $startOfThisMonth,
        CarbonInterface $endOfThisMonth,
        CarbonInterface $startOfTimeframe,
        CarbonInterface $endOfTimeframe
    ): Builder;

    public function getUserStatsQuery(
        CarbonInterface $startOfLastMonth,
        CarbonInterface $endOfLastMonth,
        CarbonInterface $startOfThisMonth,
        CarbonInterface $endOfThisMonth,
        CarbonInterface $startOfTimeframe,
        CarbonInterface $endOfTimeframe
    ): Builder;

    public function getParticipantionQuery(?CarbonInterface $start, ?CarbonInterface $end): Builder;

    public function getPostingStatsQuery(CarbonInterface $start, CarbonInterface $end): Builder;
}
