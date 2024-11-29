<?php

declare(strict_types=1);

namespace Nova\Setup\Steps;

abstract class Step
{
    abstract public function icon(): string;

    abstract public function title(): string;

    abstract public function isComplete(): bool;

    abstract public function isCurrent(): bool;

    public function icon(): string
    {
        //
    }
}
