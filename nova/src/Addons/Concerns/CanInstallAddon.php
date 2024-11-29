<?php

declare(strict_types=1);

namespace Nova\Addons\Concerns;

trait CanInstallAddon
{
    public function hasInstall(): bool
    {
        return method_exists($this, 'install');
    }

    public function installDescription(): ?string
    {
        return null;
    }
}
