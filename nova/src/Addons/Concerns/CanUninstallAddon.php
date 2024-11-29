<?php

declare(strict_types=1);

namespace Nova\Addons\Concerns;

trait CanUninstallAddon
{
    public function hasUninstall(): bool
    {
        return method_exists($this, 'uninstall');
    }

    public function uninstallDescription(): ?string
    {
        return null;
    }
}
