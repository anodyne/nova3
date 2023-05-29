<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire;

use Illuminate\Support\Str;
use Livewire\Component;
use Nova\Foundation\Icons\IconSets;

class IconsSelectMenu extends Component
{
    public $search;

    public $selected;

    public function selectIcon($icon)
    {
        $this->selected = ($icon === '') ? null : $icon;

        $this->dispatchBrowserEvent('icons-dropdown-close');

        $this->reset('search');
    }

    public function getFilteredIconsProperty(): array
    {
        $allIcons = app(IconSets::class)->getDefault()->map();
        ksort($allIcons);

        if ($this->search === null) {
            return $allIcons;
        } else {
            return collect($allIcons)
                ->filter(fn ($value, $key) => Str::contains($key, trim(strtolower($this->search))))
                ->toArray();
        }
    }

    public function render()
    {
        return view('livewire.icons', [
            'icons' => $this->filteredIcons,
        ]);
    }
}
