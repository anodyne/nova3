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
use Nova\Foundation\Events\ModelOrderChanged;

abstract class TableComponent extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    use InteractsWithTable {
        InteractsWithTable::reorderTable as filamentReorderTable;
    }

    public bool $simple = false;

    public bool $rounded = false;

    abstract public function table(Table $table): Table;

    // FIXME: this will break with Filament v4 due to the signature changing
    public function reorderTable(array $order): void
    {
        $this->filamentReorderTable($order);

        $model = $this->getTable()->getModel();

        ModelOrderChanged::dispatch($model);
    }

    public function render(): ?View
    {
        return view('livewire.filament-table');
    }
}
