<?php

namespace Nova\Foundation\Http\Livewire;

use Livewire\Component;

class ToggleSwitch extends Component
{
    public $active;

    public $color;

    public $fieldName;

    public $label;

    public function mount(bool $active = false, $fieldName, $label = null, $color = 'bg-primary-500')
    {
        $this->active = $active;
        $this->color = $color;
        $this->fieldName = $fieldName;
        $this->label = $label;
    }

    public function toggle()
    {
        $this->active = !$this->active;
    }

    public function render()
    {
        return view('livewire.form.toggle-switch');
    }
}
