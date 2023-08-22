<?php

declare(strict_types=1);

namespace Nova\Roles\Livewire;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Nova\Roles\Models\Permission;

class PermissionsList extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Permission::query())
            ->columns([
                TextColumn::make('display_name')
                    ->titleColumn()
                    ->label('Name')
                    ->description(fn (Model $record): string => $record->name)
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query->searchFor($search)),
                TextColumn::make('description')->wrap(),
            ])
            ->heading('Permissions')
            ->description('View all of the available permissions in Nova')
            ->headerActions([
                Action::make('permissions')
                    ->url(route('roles.index'))
                    ->link()
                    ->label('Back to roles')
                    ->color('gray')
                    ->icon(iconName('arrow-left'))
                    ->size('md'),
            ]);
    }

    public function render()
    {
        return view('livewire.filament-table');
    }
}
