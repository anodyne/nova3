<?php

namespace Nova\Foundation\View\Components;

use Illuminate\View\Component;

class FormField extends Component
{
    public $clean;

    public $fieldId;

    public $label;

    public function __construct($label = null, $fieldId = null, $clean = false)
    {
        $this->label = $label;
        $this->fieldId = $fieldId;
        $this->clean = $clean;
    }

    public function render()
    {
        return view('components.form.field');
    }
}
