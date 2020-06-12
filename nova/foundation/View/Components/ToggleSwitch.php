<?php

namespace Nova\Foundation\View\Components;

use Illuminate\View\Component;

class ToggleSwitch extends Component
{
    public $name;

    public $value;

    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function render()
    {
        return view('components.form.toggle-switch');
    }
}
