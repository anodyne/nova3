<?php

declare(strict_types=1);

namespace Nova\Addons\Concerns;

trait HasAddonSettings
{
    public function settingsForm(): array
    {
        return [];
    }
}
