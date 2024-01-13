<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire;

use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Foundation\Icons\IconSets;

class IconPicker extends Component
{
    public string $search = '';

    public string $selected = '';

    public function selectIcon(string $icon): void
    {
        $this->selected = $icon;

        $this->dispatch('dropdown-close');

        $this->reset('search');
    }

    #[Computed]
    public function filteredIcons(): array
    {
        $allIcons = app(IconSets::class)->getDefault()->map();
        ksort($allIcons);

        if (blank($this->search)) {
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
