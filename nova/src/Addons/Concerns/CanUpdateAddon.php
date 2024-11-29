<?php

declare(strict_types=1);

namespace Nova\Addons\Concerns;

trait CanUpdateAddon
{
    public function hasUpdate(): bool
    {
        return method_exists($this, 'update');
    }

    public function updateDescription(): ?string
    {
        return null;
    }
}
