<?php

declare(strict_types=1);

namespace Nova\Setup\Steps;

abstract class SetupSteps
{
    /** @return list<Step> */
    abstract public function steps(): array;
}
