<?php

declare(strict_types=1);

namespace Nova\Settings\Enums;

use Carbon\CarbonInterface;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Facades\Date;
use Nova\Foundation\Concerns\HasSelectOptions;

enum PostingTimeframe: string implements HasLabel
{
    use HasSelectOptions;

    case Weekly = 'weekly';

    case Monthly = 'monthly';

    case Rolling = 'rolling';

    public function getLabel(): ?string
    {
        return ucfirst($this->value);
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Monthly => 'A calendar month starting on the 1st and ending on the last day of the month',
            self::Rolling => 'A rolling period encompassing the last specified number of days from today',
            self::Weekly => 'A rolling week encompassing the last 7 days from today',
        };
    }

    public function getActivityLabel(): ?string
    {
        $days = settings('posting_activity.rollingDays');

        return match ($this) {
            self::Rolling => $days.'-day',
            default => ucfirst($this->value),
        };
    }

    public function getStatsLabel(): ?string
    {
        $days = settings('posting_activity.rollingDays');

        return match ($this) {
            self::Monthly => 'This Month',
            self::Rolling => 'Last '.$days.' days',
            self::Weekly => 'This Week',
        };
    }

    public function startDate(): CarbonInterface
    {
        return match ($this) {
            self::Monthly => Date::now()->startOfMonth(),
            self::Weekly => Date::now()->startOfWeek(),
            self::Rolling => Date::now()->subDays(settings('posting_activity.rollingDays'))->startOfDay(),
        };
    }

    public function endDate(): CarbonInterface
    {
        return match ($this) {
            self::Monthly => Date::now()->endOfMonth(),
            self::Weekly => Date::now()->endOfWeek(),
            self::Rolling => Date::now()->endOfDay(),
        };
    }
}
