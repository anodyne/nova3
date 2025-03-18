<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Concerns;

use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Date;

trait HandlesDates
{
    protected function convertDate(?int $timestamp, mixed $default = null): ?CarbonInterface
    {
        if (is_null($timestamp) || $timestamp === 0) {
            return $default;
        }

        return Date::createFromTimestampUTC($timestamp);
    }
}
