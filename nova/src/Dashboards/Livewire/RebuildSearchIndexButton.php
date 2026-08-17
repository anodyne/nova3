<?php

declare(strict_types=1);

namespace Nova\Dashboards\Livewire;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Renderless;
use Livewire\Component;

class RebuildSearchIndexButton extends Component
{
    #[Renderless]
    public function clear(): void
    {
        Cache::flush();

        Artisan::call('icons:cache');
    }

    public function render()
    {
        return <<<'blade'
            <x-button type="button" wire:click="clear">
                <x-icon :name="Tabler::Hammer" size="sm" />
                Re-build
            </x-button>
        blade;
    }
}
