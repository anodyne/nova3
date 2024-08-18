<?php

declare(strict_types=1);

namespace Nova\Applications\Livewire;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;
use Nova\Applications\Enums\ApplicationResult;
use Nova\Applications\Models\Application;
use Nova\Foundation\Livewire\TableComponent;

class ApplicationsList extends TableComponent
{
    #[Url]
    public ?array $tableFilters = [
        'result',
    ];

    public function table(Table $table): Table
    {
        return $table
            ->query(Application::with('character.positions', 'user'))
            ->groups([
                Group::make('result')->collapsible(),
            ])
            ->recordUrl(fn (Application $record): string => route('applications.show', $record))
            ->columns([
                TextColumn::make('character.name')
                    ->titleColumn()
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query->searchFor($search))
                    ->sortable(),
                TextColumn::make('character.positions.name')
                    ->label('Position')
                    ->listWithLineBreaks(),
                TextColumn::make('user.name')
                    ->description(fn (Application $record): ?string => $record->user->is_pending ? 'New user' : null)
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query->searchFor($search))
                    ->sortable(),
                TextColumn::make('result')
                    ->badge()
                    ->color(fn (Application $record): string => $record->result->color())
                    ->toggleable(),
                TextColumn::make('ip_address')
                    ->label('IP address')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('created_at')
                    ->label('Applied at')
                    ->date()
                    ->dateTimeTooltip()
                    ->toggleable(),
                TextColumn::make('decision_date')
                    ->label('Decided at')
                    ->date()
                    ->dateTimeTooltip()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('result')
                    ->multiple()
                    ->options(ApplicationResult::class),
            ])
            ->emptyStateIcon(iconName('progress'))
            ->emptyStateHeading('No applications found');
    }
}
