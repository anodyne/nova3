<?php

declare(strict_types=1);

namespace Nova\Themes\Concerns;

use Filament\Schemas\Components\Component;

trait HasThemeSettings
{
    /** @return list<Component> */
    public function settingsForm(): array
    {
        return [];
    }
}
