<?php

declare(strict_types=1);

namespace Nova\Dashboards\Livewire;

use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Renderless;
use Livewire\Component;
use Nova\Foundation\Enums\CacheKeys;

class ClearVersionCheckCacheButton extends Component
{
    #[Renderless]
    public function clear(): void
    {
        Cache::forget(CacheKeys::LatestVersion->value);
        Cache::forget(CacheKeys::UpdateAvailable->value);
    }

    public function render(): string
    {
        return <<<'blade'
            <x-button type="button" wire:click="clear">
                <x-icon :name="Tabler::Eraser" size="sm" />
                Clear
            </x-button>
        blade;
    }
}
