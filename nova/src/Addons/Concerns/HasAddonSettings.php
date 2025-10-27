<?php

declare(strict_types=1);

namespace Nova\Addons\Concerns;

trait HasAddonSettings
{
    public function hasSettings(): bool
    {
        return count($this->settingsForm()) > 0;
    }

    public function settingsForm(): array
    {
        return [];
    }
}
