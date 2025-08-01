<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire;

use Filament\Schemas\Schema;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;
use Livewire\Component;

abstract class FormComponent extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    protected string $view = 'livewire.filament-form';

    abstract public function form(Schema $schema): Schema;

    public function render(): ?View
    {
        return view($this->view);
    }
}
