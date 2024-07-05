<?php

declare(strict_types=1);

namespace Nova\Pages\Livewire;

use Livewire\Component;
use Nova\Forms\Models\Form;

class DynamicForm extends Component
{
    public ?string $formKey = null;

    public Form $form;

    public function mount(string $formKey)
    {
        $this->form = Form::key($formKey)->sole();
    }

    public function render()
    {
        return view('pages.pages.livewire.dynamic-form');
    }
}
