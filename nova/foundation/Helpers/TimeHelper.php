<?php

declare(strict_types=1);

namespace Nova\Foundation\Helpers;

use Carbon\CarbonInterval;

class TimeHelper
{
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
