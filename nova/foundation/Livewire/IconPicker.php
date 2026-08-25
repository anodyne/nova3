<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Foundation\Actions\RecacheIcons;
use Nova\Foundation\Enums\CacheKeys;

/**
 * @property-read array<int, string> $filteredIcons
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

    /** @return array<int, string> */
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

        return collect(Arr::wrap(Cache::get(CacheKeys::SearchableIcons->value, [])))
            ->map(function (mixed $icon) use ($query): ?string {
                if (! is_array($icon)) {
                    return null;
                }

                $searchable = data_get($icon, 'searchable');
                $value = data_get($icon, 'value');

                if (! is_string($searchable) || ! is_string($value)) {
                    return null;
                }

                return str_contains($searchable, $query) ? $value : null;
            })
            ->filter()
            ->take(25)
            ->values()
            ->all();
    }
}
