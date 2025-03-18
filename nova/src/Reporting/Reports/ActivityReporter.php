<?php

declare(strict_types=1);

namespace Nova\Reporting\Reports;

use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Date;
use Nova\Reporting\Data\ActivityReport;
use Nova\Reporting\Repositories\ReportingRepositoryInterface;
use Nova\Settings\Data\PostingActivity;
use Nova\Settings\Enums\PostingTarget;
use Nova\Users\Models\Login;

class ActivityReporter
{
    protected PostingActivity $postingActivitySettings;

    public function __construct()
    {
        $this->postingActivitySettings = settings('posting_activity');
    }

    public function currentActivityTimeframe(): ActivityReport
    {
        $result = once(function () {
            return $this->query(
                start: $this->postingActivitySettings->timeframe->startDate(),
                end: $this->postingActivitySettings->timeframe->endDate()
            );
        });

        return ActivityReport::from(
            active: $this->calculateActive($result),
            total: $result->count(),
            results: $result
        );
    }

    public function previousActivityTimeframe(): ActivityReport
    {
        $result = once(function () {
            return $this->query(
                start: $this->postingActivitySettings->timeframe->previousStartDate(),
                end: $this->postingActivitySettings->timeframe->previousEndDate()
            );
        });

        return ActivityReport::from(
            active: $this->calculateActive($result),
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
            ->getActivityQuery($start, $end)
            ->get()
            ->map(function ($user) {
                // Convert `latest_login` to Carbon, handling null values
                $user->latest_login = $user->latest_login ? Date::parse($user->latest_login) : null;

                return $user;
            });
    }

    protected function calculateActive(Collection $result): int
    {
        $settings = settings('posting_activity');

        return $result
            ->where('login_count', '>', 0)
            ->when(
                $settings->target === PostingTarget::Posts,
                fn (Collection $collection): Collection => $collection->where('published_post_count', '>=', $settings->requirement)
            )
            ->when(
                $settings->target === PostingTarget::Words,
                fn (Collection $collection): Collection => $collection->where('total_word_count', '>=', $settings->requirement)
            )
            ->count();
    }
}
