<?php

declare(strict_types=1);

namespace Nova\Dashboards\Livewire;

use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Renderless;
use Livewire\Component;

class ClearVersionCheckCacheButton extends Component
{
    #[Renderless]
    public function clear(): void
    {
        Cache::forget('nova-latest-version');
        Cache::forget('nova-update-available');
    }

    public function render()
    {
        return <<<'blade'
            <x-button type="button" color="neutral" wire:click="clear">
                <x-icon :name="Icon::Eraser" size="sm"></x-icon>
                Clear
            </x-button>
        blade;
    }
}
