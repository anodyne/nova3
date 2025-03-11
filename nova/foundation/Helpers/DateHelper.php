<?php

declare(strict_types=1);

namespace Nova\Foundation\Helpers;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Nova\Users\Models\User;

class DateHelper
{
    /**
     * Return a date according to the timezone of the user, and the format
     * stored in the preferences for this user.
     */
    public static function format(CarbonInterface $date, User $user): string
    {
        return $date->isoFormat($user->date_format);
    }

    /**
     * Return a date according to the timezone of the user, in a
     * short format like "Oct 29, 1981".
     */
    public static function formatDate(CarbonInterface $date, ?string $timezone = null): string
    {
        $date->setTimezone($timezone ?? static::getUserTimezone());

        return $date->isoFormat(trans('format.date'));
    }

    /**
     * Return a date and the time according to the timezone of the user, in a
     * short format like "Oct 29, 1981 19:32".
     */
    public static function formatShortDateWithTime(CarbonInterface $date, ?string $timezone = null): string
    {
        $date->setTimezone($timezone ?? static::getUserTimezone());

        return $date->isoFormat(trans('format.short_date_year_time'));
    }

    /**
     * Return the day and the month in a format like "July 29th".
     */
    public static function formatMonthAndDay(CarbonInterface $date, ?string $timezone = null): string
    {
        $date->setTimezone($timezone ?? static::getUserTimezone());

        return $date->isoFormat(trans('format.long_month_day'));
    }

    /**
     * Return the short month and the year in a format like "Jul 2020".
     */
    public static function formatMonthAndYear(CarbonInterface $date, ?string $timezone = null): string
    {
        $date->setTimezone($timezone ?? static::getUserTimezone());

        return $date->isoFormat(trans('format.short_month_year'));
    }

    /**
     * Return the long month and the year in a format like "September 2020".
     */
    public static function formatLongMonthAndYear(CarbonInterface $date, ?string $timezone = null): string
    {
        $date->setTimezone($timezone ?? static::getUserTimezone());

        return $date->isoFormat(trans('format.long_month_year'));
    }

    /**
     * Return the day and the month in a format like "Jul 29".
     */
    public static function formatShortMonthAndDay(CarbonInterface $date, ?string $timezone = null): string
    {
        $date->setTimezone($timezone ?? static::getUserTimezone());

        return $date->isoFormat(trans('format.short_date'));
    }

    /**
     * Return the day in a format like "Mon".
     */
    public static function formatShortDay(CarbonInterface $date, ?string $timezone = null): string
    {
        $date->setTimezone($timezone ?? static::getUserTimezone());

        return $date->isoFormat(trans('format.short_day'));
    }

    /**
     * Return the day and the month in a format like "Monday (July 29th)".
     */
    public static function formatDayAndMonthInParenthesis(CarbonInterface $date, ?string $timezone = null): string
    {
        $date->setTimezone($timezone ?? static::getUserTimezone());

        return $date->isoFormat(trans('format.day_month_parenthesis'));
    }

    /**
     * Return the complete date like "Monday, July 29th 2020".
     */
    public static function formatFullDate(CarbonInterface $date, ?string $timezone = null): string
    {
        $date->setTimezone($timezone ?? static::getUserTimezone());

        return $date->isoFormat(trans('format.full_date'));
    }

    /**
     * Return the day as a number, like "03".
     */
    public static function formatDayNumber(CarbonInterface $date, ?string $timezone = null): string
    {
        $date->setTimezone($timezone ?? static::getUserTimezone());

        return $date->isoFormat(trans('format.day_number'));
    }

    /**
     * Return the first letter of the month, like "Jan" for January.
     */
    public static function formatMonthNumber($date, ?string $timezone = null): string
    {
        $date->setTimezone($timezone ?? static::getUserTimezone());

        return $date->isoFormat(trans('format.short_month'));
    }

    /**
     * Return a collection of months.
     */
    public static function getMonths(): Collection
    {
        $monthsCollection = collect();
        $year = Carbon::now()->year;
        for ($month = 1; $month <= 12; $month++) {
            $monthsCollection->push([
                'id' => $month,
                'name' => Carbon::create($year, $month, 1)->isoFormat('MMMM'),
            ]);
        }

        return $monthsCollection;
    }

    /**
     * Return a collection of days.
     */
    public static function getDays(): Collection
    {
        $daysCollection = collect();
        for ($day = 1; $day <= 31; $day++) {
            $daysCollection->push([
                'id' => $day,
                'name' => $day,
            ]);
        }

        return $daysCollection;
    }

    /**
     * Return the date as timestamp.
     */
    public static function getTimestamp(?CarbonInterface $date): string
    {
        return $date ? $date->translatedFormat(config('api.timestamp_format')) : '';
    }

    public static function getUserTimezone(): string
    {
        $userTimezone = Auth::user()?->preferences?->timezone;

        return filled($userTimezone) ? $userTimezone : 'UTC';
    }
}
