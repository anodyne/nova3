<?php

declare(strict_types=1);

namespace Nova\Foundation\Helpers;

use Carbon\Carbon;
use Carbon\CarbonInterval;

class TimeHelper
{
    public static function formatShortTime(Carbon $date, ?string $timezone = null): string
    {
        if ($timezone) {
            $date->setTimezone($timezone);
        }

        return $date->isoFormat(trans('format.short_time'));
    }

    public static function formatLongTime(Carbon $date, ?string $timezone = null): string
    {
        if ($timezone) {
            $date->setTimezone($timezone);
        }

        return $date->isoFormat(trans('format.long_time'));
    }

    public static function readingTime(int $words): string
    {
        $minutes = ceil($words / 200);

        return CarbonInterval::minutes($minutes)
            ->cascade()
            ->forHumans(
                syntax: ['parts' => 2],
                short: true
            );
    }
}
