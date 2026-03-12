<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Livewire\Component;

abstract class InfolistComponent extends Component implements HasForms, HasInfolists
{
    use InteractsWithForms;
    use InteractsWithInfolists;

    abstract public function infolist(Schema $schema): Schema;

    public function render(): ?View
    {
        return view('livewire.filament-infolist');
    }
}
