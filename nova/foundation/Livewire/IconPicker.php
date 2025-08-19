<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire;

use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Foundation\Actions\RecacheIcons;

class IconPicker extends Component
{
    public string $field = 'icon';

    public string $query = '';

    public ?string $selected = null;

    public function mount()
    {
        if (Cache::missing('tabler.icons.searchable')) {
            RecacheIcons::run();
        }
    }

    public function render()
    {
        return view('livewire.icon-picker', [
            'filteredIcons' => $this->filteredIcons,
        ]);
    }

    #[Computed]
    public function filteredIcons(): array
    {
        $query = strtolower($this->query);

        if (blank($query)) {
            if (filled($this->selected)) {
                return [$this->selected];
            }

            return [];
        }

        $icons = Cache::get('tabler.icons.searchable', []);

        return collect($icons)
            ->filter(fn ($icon) => str_contains($icon['searchable'], $query))
            ->take(25)
            ->map(fn ($icon) => $icon['value'])
            ->toArray();
    }
}
