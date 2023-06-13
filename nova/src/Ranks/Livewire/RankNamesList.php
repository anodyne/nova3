<?php

declare(strict_types=1);

namespace Nova\Ranks\Livewire;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Livewire\Component;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ReplicateAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Ranks\Actions\DeleteRankName;
use Nova\Ranks\Actions\DuplicateRankName;
use Nova\Ranks\Enums\RankNameStatus;
use Nova\Ranks\Events\RankNameDuplicated;
use Nova\Ranks\Models\RankName;

class RankNamesList extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(RankName::query())
            ->defaultSort('order_column', 'asc')
            ->columns([
                TextColumn::make('name')
                    ->titleColumn()
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query->searchFor($search))
                    ->sortable(),
                TextColumn::make('ranks_count')
                    ->counts('ranks')
                    ->label('# of ranks')
                    ->alignCenter()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (Model $record) => $record->status->color())
                    ->toggleable(),
            ])
            ->actions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make()
                            ->authorize('view')
                            ->url(fn (Model $record): string => route('ranks.names.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Model $record): string => route('ranks.names.edit', $record)),
                    ])->authorizeAny(['view', 'update'])->divided(),
                    ActionGroup::make([
                        ReplicateAction::make()
                            ->action(function (Model $record): void {
                                $replica = DuplicateRankName::run($record);

                                dispatch(new RankNameDuplicated($replica, $record));

                                Notification::make()->success()
                                    ->title("{$replica->name} rank name has been created")
                                    ->send();
                            }),
                    ])->authorize('duplicate')->divided(),
                    ActionGroup::make([
                        DeleteAction::make()
                            ->modalHeading('Delete rank name?')
                            ->modalSubheading(
                                fn (Model $record): string => "Are you sure you want to delete the {$record->name} rank name? This will also delete all ranks associated with the name and any characters with those ranks will need to have new ranks assigned to them."
                            )
                            ->modalSubmitActionLabel('Delete')
                            ->successNotificationTitle('Rank name was deleted')
                            ->using(fn (Model $record): Model => DeleteRankName::run($record)),
                    ])->authorize('delete')->divided(),
                ]),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->authorize('deleteAny')
                    ->modalHeading(
                        fn (Collection $records): string => "Delete {$records->count()} selected ".str('rank name')->plural($records->count()).'?'
                    )
                    ->modalSubheading(function (Collection $records): string {
                        $statement = ($records->count() === 1)
                            ? 'this 1 rank name'
                            : "these {$records->count()} rank names";

                        $notice = ($records->count() === 1) ? 'it' : 'them';

                        return "Are you sure you want to delete {$statement}? You won't be able to recover {$notice}. This will also delete all ranks within the group(s) and any characters with those ranks will need to have new ranks assigned to them.";
                    })
                    ->modalSubmitActionLabel('Delete')
                    ->successNotificationTitle('Rank names were deleted')
                    ->using(fn (Collection $records): Collection => $records->each(
                        fn (Model $record): Model => DeleteRankName::run($record)
                    )),
            ])
            ->filters([
                TernaryFilter::make('assigned_ranks')
                    ->label('Has assigned ranks')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->whereHas('ranks'),
                        false: fn (Builder $query): Builder => $query->whereDoesntHave('ranks')
                    ),
                SelectFilter::make('status')->options(RankNameStatus::class),
            ])
            ->reorderable('order_column')
            ->heading('Rank names')
            ->description('Re-use basic rank information across all of your rank items')
            ->headerActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add')
                    ->url(route('ranks.names.create')),
            ])
            ->header(fn () => $this->isTableReordering() ? view('filament.tables.reordering-notice') : null)
            ->emptyStateIcon(iconName('info'))
            ->emptyStateHeading('No rank names found')
            ->emptyStateDescription('Rank names eliminate the repetitive task of setting the name of a rank by letting you re-use names across all of your rank items.')
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add a rank name')
                    ->url(route('ranks.names.create')),
            ]);
    }

    public function render()
    {
        return view('livewire.filament-table');
    }
}
