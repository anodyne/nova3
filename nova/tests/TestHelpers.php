<?php

namespace Tests;

trait TestHelpers
{
    public function disableRoleCaching(): self
    {
        config(['laratrust.cache.enabled' => false]);

        return $this;
    }
}
