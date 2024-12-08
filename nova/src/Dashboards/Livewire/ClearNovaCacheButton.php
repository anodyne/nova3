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

        Artisan::run('icons:cache');
    }

    public function render()
    {
        return <<<'blade'
            <x-button type="button" color="neutral" wire:click="clear">
                <x-icon name="eraser" size="sm"></x-icon>
                Clear
            </x-button>
        blade;
    }
}
