<?php

declare(strict_types=1);

namespace Nova\Applications\Livewire;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Nova\Applications\Enums\ApplicationResult;
use Nova\Applications\Models\Application;
use Nova\Foundation\Icons\Illustration;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Users\Models\User;

class ApplicationsList extends TableComponent
{
    #[Url]
    public ?array $tableFilters = [
        'result',
    ];

    public function table(Table $table): Table
    {
        /** @var User $user */
        $user = Auth::user();

        return $table
            ->query(
                Application::with('character.positions', 'user')
                    ->select([
                        'character_id',
                        'created_at',
                        'decision_date',
                        'id',
                        'ip_address',
                        'result',
                        'user_id',
                    ])
                    ->unless(
                        $user->isAbleTo('application.approve'),
                        fn (Builder $query): Builder => $query->reviewedBy($user)
                    )
            )
            ->defaultSort('created_at', 'desc')
            ->groups([
                Group::make('result')->collapsible(),
            ])
            ->recordUrl(fn (Application $record): string => route('admin.applications.show', $record))
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
            ->emptyStateIcon(Illustration::HandpickResume)
            ->emptyStateHeading('No applications found');
    }
}
