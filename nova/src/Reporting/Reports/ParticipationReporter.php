<?php

declare(strict_types=1);

namespace Nova\Reporting\Reports;

use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Nova\Reporting\Data\ParticipationReport;
use Nova\Reporting\Repositories\ReportingRepositoryInterface;
use Nova\Settings\Data\PostingActivity;

class ParticipationReporter
{
    protected PostingActivity $postingActivitySettings;

    public function __construct()
    {
        $this->postingActivitySettings = settings('posting_activity');
    }

    public function currentActivityTimeframe(): ParticipationReport
    {
        $result = once(function () {
            return $this->query(
                start: $this->postingActivitySettings->timeframe->startDate(),
                end: $this->postingActivitySettings->timeframe->endDate()
            );
        });

        return ParticipationReport::from(
            active: $result->where('total_word_count', '>', 0)->count(),
            total: $result->count(),
            results: $result
        );
    }

    public function previousActivityTimeframe(): ParticipationReport
    {
        $result = once(function () {
            return $this->query(
                start: $this->postingActivitySettings->timeframe->previousStartDate(),
                end: $this->postingActivitySettings->timeframe->previousEndDate()
            );
        });

        return ParticipationReport::from(
            active: $result->where('total_word_count', '>', 0)->count(),
            total: $result->count(),
            results: null
        );
    }

    public function percentageChange(): int
    {
        $previous = $this->previousActivityTimeframe()->percentage();
        $current = $this->currentActivityTimeframe()->percentage();

        if ($previous === 0 && $current > 0) {
            return 100;
        }

        if ($previous === 0 && $current === 0) {
            return 0;
        }

        $diff = (($current - $previous) / $previous) * 100;

        return intval(round($diff, 0));
    }

    public function percentageChangeBadge(): string
    {
        $change = $this->percentageChange();

        return match (true) {
            $change > 0 => Blade::render('<x-badge color="success">&uarr; '.$change.'%</x-badge>'),
            $change < 0 => Blade::render('<x-badge color="danger">&darr; '.abs($change).'%</x-badge>'),
            default => '',
        };
    }

    public static function make(): static
    {
        return new self;
    }

    protected function query(?CarbonInterface $start = null, ?CarbonInterface $end = null): Collection
    {
        return app(ReportingRepositoryInterface::class)
            ->getParticipantionQuery($start, $end)
            ->get();
    }
}
