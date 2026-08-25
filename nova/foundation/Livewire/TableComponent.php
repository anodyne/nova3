<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Nova\Foundation\Events\ModelOrderChanged;

abstract class TableComponent extends Component implements HasActions, HasForms, HasTable
{
    use InteractsWithActions;
    use InteractsWithForms;
    use InteractsWithTable;
    use InteractsWithTable {
        InteractsWithTable::reorderTable as filamentReorderTable;
    }

    public bool $simple = false;

    public bool $rounded = false;

    abstract public function table(Table $table): Table;

    /** @param array<int|string, int|string> $order */
    public function reorderTable(array $order, int|string|null $draggedRecordKey = null): void
    {
        $this->filamentReorderTable($order, $draggedRecordKey);

        $model = $this->getTable()->getModel();

        ModelOrderChanged::dispatch($model);
    }

    public function render(): ?View
    {
        return view('livewire.filament-table');
    }
}
