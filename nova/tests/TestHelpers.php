<?php

declare(strict_types=1);

namespace Tests;

trait TestHelpers
{
    public function disableRoleCaching(): self
    {
        config(['laratrust.cache.enabled' => false]);

        return $this;
    }
}
