<?php

namespace Nova\Foundation\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use Nova\Foundation\Icons\IconSets;

class IconsSelectMenu extends Component
{
    public $icons;

    public $search;

    public $selected;

    public $allIcons;

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
        $this->search = null;
        $this->icons = $this->allIcons;
    }
}
