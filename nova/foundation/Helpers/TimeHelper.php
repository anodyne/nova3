<?php

declare(strict_types=1);

namespace Nova\Foundation\Helpers;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\Auth;

class TimeHelper
{
    public static function formatShortTime(Carbon $date, ?string $timezone = null): string
    {
        $date->setTimezone($timezone ?? static::getUserTimezone());

        return $date->isoFormat(trans('format.short_time'));
    }

    public static function formatLongTime(Carbon $date, ?string $timezone = null): string
    {
        $date->setTimezone($timezone ?? static::getUserTimezone());

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

    public static function getUserTimezone(): string
    {
        return Auth::user()->preferences->timezone ?? 'UTC';
    }
}
