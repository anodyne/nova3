<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire;

use Illuminate\Support\Str;
use Livewire\Component;
use Nova\Foundation\Icons\IconSets;

class IconsSelectMenu extends Component
{
    public $allIcons;

    public $icons;

    public $search;

    public $selected;

    public function selectIcon($icon)
    {
        $this->selected = ($icon === '') ? null : $icon;

        $this->resetIcons();
    }

    public function updatedSearch($search)
    {
        if ($search == null) {
            $this->resetIcons();
        } else {
            $this->icons = collect($this->allIcons)
                ->filter(fn ($value, $key) => Str::contains($key, trim(strtolower($search))))
                ->toArray();
        }
    }

    public function mount()
    {
        $this->allIcons = app(IconSets::class)->getDefaultSet()->map();
        ksort($this->allIcons);

        $this->resetIcons();
    }

    public function render()
    {
        return view('livewire.icons');
    }

    protected function resetIcons()
    {
        $this->reset('search');
        $this->icons = $this->allIcons;
    }
}
