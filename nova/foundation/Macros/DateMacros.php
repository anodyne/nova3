<?php

declare(strict_types=1);

namespace Nova\Foundation\Macros;

use Carbon\CarbonInterface;
use Closure;
use Illuminate\Support\Facades\Auth;

class DateMacros
{
    /**
     * Return a short date according to the timezone of the user.
     * Example: Apr 15, 2010
     */
    public function formatDate(): Closure
    {
        return function (): string {
            /** @var CarbonInterface $date */
            $date = $this;

            return $date->local()->isoFormat('MMM DD, YYYY');
        };
    }

    /**
     * Return a short date with time according to the timezone of the user.
     * Example: Apr 15, 2010 04:30 PM
     */
    public function formatDateWithTime(): Closure
    {
        return function (): string {
            /** @var CarbonInterface $date */
            $date = $this;

            return $date->local()->isoFormat('MMM DD, YYYY hh:mm A');
        };
    }

    /**
     * Return a full date according to the timezone of the user.
     * Example: Thursday, April 15th 2010
     */
    public function formatFullDate(): Closure
    {
        return function (): string {
            /** @var CarbonInterface $date */
            $date = $this;

            return $date->local()->isoFormat('dddd, MMM Do YYYY');
        };
    }

    /**
     * Return a full date according to the timezone of the user.
     * Example: Thursday, April 15th 2010 04:30 PM
     */
    public function formatFullDateWithTime(): Closure
    {
        return function (): string {
            /** @var CarbonInterface $date */
            $date = $this;

            return $date->local()->isoFormat('dddd, MMM Do YYYY hh:mm A');
        };
    }

    /**
     * Return a long time according to the timezone of the user.
     * Example: 16:30
     */
    public function formatLongTime(): Closure
    {
        return function (): string {
            /** @var CarbonInterface $date */
            $date = $this;

            return $date->local()->isoFormat('HH:mm');
        };
    }

    /**
     * Return a short time according to the timezone of the user.
     * Example: Apr 15, 2010 04:30 PM
     */
    public function formatShortTime(): Closure
    {
        return function (): string {
            /** @var CarbonInterface $date */
            $date = $this;

            return $date->local()->isoFormat('h:mm A');
        };
    }

    /**
     * Set the timezone according to the timezone of the user.
     */
    public function local(): Closure
    {
        return function (): CarbonInterface {
            /** @var CarbonInterface $date */
            $date = $this;

            return $date->setTimezone(Auth::user()->preferences->timezone ?? 'UTC');
        };
    }
}
