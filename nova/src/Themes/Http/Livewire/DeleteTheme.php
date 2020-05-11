<?php

namespace Nova\Themes\Http\Livewire;

use Livewire\Component;
use Nova\Themes\Models\Theme;

class DeleteTheme extends Component
{
    public $itemId;

    public $themeName;

    public function mount()
    {
        //
    }

    public function updatedItemId()
    {
        $theme = Theme::findOrFail($this->itemId);

        $this->themeName = $theme->name;
    }

    public function render()
    {
        return view('livewire.delete-theme');
    }
}
