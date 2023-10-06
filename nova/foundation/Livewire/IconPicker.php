<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire;

use Illuminate\Support\Str;
use Livewire\Component;
use Nova\Foundation\Icons\IconSets;

class IconPicker extends Component
{
    public ?string $search = null;

    public ?string $selected = null;

    public function selectIcon($icon)
    {
        $this->selected = ($icon === '') ? null : $icon;

        $this->dispatch('icons-dropdown-close');

        $this->reset('search');
    }

    public function getFilteredIconsProperty(): array
    {
        $allIcons = app(IconSets::class)->getDefault()->map();
        ksort($allIcons);

        if ($this->search === null) {
            return $allIcons;
        }

        return collect($allIcons)
            ->filter(fn ($value, $key) => Str::contains($key, trim(strtolower($this->search))))
            ->all();
    }

    public function render()
    {
        return view('livewire.icon-picker', [
            'icons' => $this->filteredIcons,
        ]);
    }
}
