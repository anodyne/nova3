<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Livewire\Component;

abstract class FormComponent extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    abstract public function form(Form $form): Form;

    public function render(): ?View
    {
        return view('livewire.filament-form');
    }
}
