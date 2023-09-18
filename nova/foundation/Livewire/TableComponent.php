<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;

abstract class TableComponent extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public bool $simple = false;

    abstract public function table(Table $table): Table;

    public function render(): ?View
    {
        return view('livewire.filament-table', [
            'simpleTable' => $this->simple,
        ]);
    }
}
