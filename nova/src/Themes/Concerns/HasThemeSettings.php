<?php

declare(strict_types=1);

namespace Nova\Themes\Concerns;

trait HasThemeSettings
{
    public function settingsForm(): array
    {
        return [];
    }
}
