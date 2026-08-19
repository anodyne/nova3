<?php

declare(strict_types=1);

namespace Nova\Pages\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Nova\Forms\Models\Form;

class DynamicForm extends Component
{
    public ?string $formKey = null;

    public Form $form;

    public function mount(string $formKey): void
    {
        $this->form = Form::key($formKey)->sole();
    }

    public function render(): Factory|View
    {
        return view('pages.pages.livewire.dynamic-form');
    }
}
