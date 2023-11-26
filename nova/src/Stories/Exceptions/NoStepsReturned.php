<?php

declare(strict_types=1);

namespace Nova\Stories\Exceptions;

use Exception;

class NoStepsReturned extends Exception
{
    public static function make(string $componentClassName): self
    {
        return new self("The `steps` function of component `{$componentClassName}` did not return any components. Make sure to return at least one component that extends `StepComponent`.");
    }
}
