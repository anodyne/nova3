<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire;

use Anodyne\TablerIcons\Tabler;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Component;

class IconPicker extends Component
{
    public string $field = 'icon';

    public string $query = '';

    public ?string $selected = null;

    public function mount()
    {
        Cache::forget('tabler.icons.searchable');

        $searchableIcons = collect(Tabler::cases())
            ->map(fn ($icon) => [
                'name' => $name = str($icon->name)->headline()->toString(),
                'value' => $icon->value,
                'searchable' => strtolower($name.' '.$icon->value),
            ])
            ->values()
            ->toArray();

        Cache::put('tabler.icons.searchable', $searchableIcons);
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
