<?php

namespace Nova\Foundation\Http\Livewire;

use Livewire\Component;

class PasswordField extends Component
{
    public $allowShowingPassword = true;

    public $fieldId;

    public $fieldName;

    public $label;

    public $password;

    public $showPassword = false;

    public function mount($label, $fieldId, $fieldName)
    {
        $this->label = $label;
        $this->fieldId = $fieldId;
        $this->fieldName = $fieldName;
    }

    public function togglePassword()
    {
        $this->showPassword = ! $this->showPassword;
    }

    public function render()
    {
        return view('livewire.form.password');
    }
}
