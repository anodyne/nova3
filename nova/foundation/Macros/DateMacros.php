<?php

declare(strict_types=1);

namespace Nova\Foundation\Macros;

use Carbon\CarbonInterface;
use Closure;
use LogicException;
use Nova\Foundation\Helpers\DateHelper;

class DateMacros
{
    /**
     * Return a short date according to the timezone of the user.
     * Example: Apr 15, 2010
     */
    public function formatDate(): Closure
    {
        return function (): string {
            if (! $this instanceof CarbonInterface) {
                throw new LogicException('Date macros must be bound to a Carbon instance.');
            }

            return DateHelper::formatDate($this);
        };
    }

    /**
     * Return a short date with time according to the timezone of the user.
     * Example: Apr 15, 2010 04:30 PM
     */
    public function formatDateWithTime(): Closure
    {
        return function (): string {
            if (! $this instanceof CarbonInterface) {
                throw new LogicException('Date macros must be bound to a Carbon instance.');
            }

            return DateHelper::formatDateWithTime($this);
        };
    }

    /**
     * Return a full date according to the timezone of the user.
     * Example: Thursday, April 15th 2010
     */
    public function formatFullDate(): Closure
    {
        return function (): string {
            if (! $this instanceof CarbonInterface) {
                throw new LogicException('Date macros must be bound to a Carbon instance.');
            }

            return DateHelper::formatFullDate($this);
        };
    }

    /**
     * Return a full date according to the timezone of the user.
     * Example: Thursday, April 15th 2010 04:30 PM
     */
    public function formatFullDateWithTime(): Closure
    {
        return function (): string {
            if (! $this instanceof CarbonInterface) {
                throw new LogicException('Date macros must be bound to a Carbon instance.');
            }

            return DateHelper::formatFullDateWithTime($this);
        };
    }

    /**
     * Return a long time according to the timezone of the user.
     * Example: 16:30
     */
    public function formatLongTime(): Closure
    {
        return function (): string {
            if (! $this instanceof CarbonInterface) {
                throw new LogicException('Date macros must be bound to a Carbon instance.');
            }

            return DateHelper::formatLongTime($this);
        };
    }

    /**
     * Return a short time according to the timezone of the user.
     * Example: Apr 15, 2010 04:30 PM
     */
    public function formatShortTime(): Closure
    {
        return function (): string {
            if (! $this instanceof CarbonInterface) {
                throw new LogicException('Date macros must be bound to a Carbon instance.');
            }

            return DateHelper::formatShortTime($this);
        };
    }

    /**
     * Set the timezone according to the timezone of the user.
     */
    public function local(): Closure
    {
        return function (): CarbonInterface {
            if (! $this instanceof CarbonInterface) {
                throw new LogicException('Date macros must be bound to a Carbon instance.');
            }

            return DateHelper::local($this);
        };
    }
}
