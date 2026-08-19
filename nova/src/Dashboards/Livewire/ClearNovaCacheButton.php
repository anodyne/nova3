<?php

declare(strict_types=1);

namespace Nova\Dashboards\Livewire;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Renderless;
use Livewire\Component;

class ClearNovaCacheButton extends Component
{
    #[Renderless]
    public function clear(): void
    {
        Cache::flush();

        Artisan::call('icons:cache');
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
