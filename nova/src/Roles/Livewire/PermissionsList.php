<?php

declare(strict_types=1);

namespace Nova\Roles\Livewire;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Roles\Models\Permission;

class PermissionsList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(Permission::query())
            ->columns([
                TextColumn::make('display_name')
                    ->titleColumn()
                    ->label('Name')
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query->searchFor($search))
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Key')
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query->searchFor($search))
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('description')
                    ->wrap()
                    ->toggleable(),
                TextColumn::make('roles.display_name')
                    ->badge()
                    ->color('gray')
                    ->wrap()
                    ->listWithLineBreaks()
                    ->label('Assigned role(s)')
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('roles')
                    ->relationship('roles', 'display_name')
                    ->multiple()
                    ->preload(),
            ]);
    }
}
