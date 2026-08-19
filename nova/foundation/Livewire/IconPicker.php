<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Foundation\Actions\RecacheIcons;
use Nova\Foundation\Enums\CacheKeys;

/**
 * @property-read array $filteredIcons
 */
class IconPicker extends Component
{
    public string $field = 'icon';

    public string $query = '';

    public ?string $selected = null;

    public function mount(): void
    {
        if (Cache::missing(CacheKeys::SearchableIcons->value)) {
            RecacheIcons::run();
        }
    }

    public function render(): Factory|View
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

        $icons = Cache::get(CacheKeys::SearchableIcons->value, []);

        return collect($icons)
            ->filter(fn ($icon): bool => str_contains($icon['searchable'], $query))
            ->take(25)
            ->map(fn ($icon): mixed => $icon['value'])
            ->toArray();
    }
}
