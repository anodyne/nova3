<?php

declare(strict_types=1);

namespace Nova\Addons\Concerns;

use Filament\Schemas\Components\Component;

trait HasAddonSettings
{
    public function hasSettings(): bool
    {
        return count($this->settingsForm()) > 0;
    }

    /**
     * @return list<Component>
     */
    public function settingsForm(): array
    {
        return [];
    }
}
