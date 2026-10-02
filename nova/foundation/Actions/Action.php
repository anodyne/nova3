<?php

declare(strict_types=1);

namespace Nova\Foundation\Actions;

use DirectoryTree\Runnable\Runnable;
use Illuminate\Support\Fluent;

abstract class Action
{
    use Runnable;

    public static function runIf(bool $boolean, mixed ...$arguments): mixed
    {
        return $boolean ? static::run(...$arguments) : new Fluent;
    }

    public static function runUnless(bool $boolean, mixed ...$arguments): mixed
    {
        return static::runIf(! $boolean, ...$arguments);
    }
}
