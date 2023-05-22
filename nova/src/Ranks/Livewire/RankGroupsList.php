<?php

declare(strict_types=1);

namespace Nova\Ranks\Livewire;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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
use Nova\Ranks\Actions\DeleteRankGroup;
use Nova\Ranks\Actions\DuplicateRankGroup;
use Nova\Ranks\Concerns\FindRankImages;
use Nova\Ranks\Data\RankGroupData;
use Nova\Ranks\Enums\RankGroupStatus;
use Nova\Ranks\Events\RankGroupDuplicated;
use Nova\Ranks\Models\RankGroup;

class RankGroupsList extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    use FindRankImages;

    public function table(Table $table): Table
    {
        return $table
            ->query(RankGroup::query())
            ->defaultSort('order_column', 'asc')
            ->columns([
                TextColumn::make('name')
                    ->titleColumn()
                    ->searchable(query: fn (Builder $query, string $search) => $query->searchFor($search))
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
                            ->url(fn (Model $record) => route('ranks.groups.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Model $record) => route('ranks.groups.edit', $record)),
                    ])->authorizeAny(['view', 'update'])->divided(),
                    ActionGroup::make([
                        ReplicateAction::make()
                            ->form([
                                TextInput::make('name')->label('New rank group name'),
                                Select::make('base_image')
                                    ->label('New base image')
                                    ->placeholder('Select a base image')
                                    ->options($this->getRankBaseImages()),
                            ])
                            ->modalHeading('Duplicate rank group?')
                            ->modalSubheading(
                                fn (Model $record) => "Are you sure you want to duplicate the {$record->name} rank group and all of its ranks?"
                            )
                            ->modalSubmitActionLabel('Duplicate')
                            ->action(function (Model $record, array $data) {
                                $replica = DuplicateRankGroup::run(
                                    $record,
                                    RankGroupData::from(array_merge($record->toArray(), $data))
                                );

                                RankGroupDuplicated::dispatch($replica, $record);

                                Notification::make()->success()
                                    ->title("{$replica->name} rank group has been created")
                                    ->body("All of the ranks from the {$record->name} rank group have been duplicated into your new rank group.")
                                    ->send();
                            }),
                    ])->authorize('duplicate')->divided(),
                    ActionGroup::make([
                        DeleteAction::make()
                            ->modalHeading('Delete rank group?')
                            ->modalSubheading(
                                fn (Model $record) => "Are you sure you want to delete the {$record->name} rank group? This will also delete all ranks within the group and any characters with those ranks will need to have new ranks assigned to them."
                            )
                            ->modalSubmitActionLabel('Delete')
                            ->successNotificationTitle('Rank group was deleted')
                            ->using(fn (Model $record) => DeleteRankGroup::run($record)),
                    ])->authorize('delete')->divided(),
                ]),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->authorize('deleteAny')
                    ->modalHeading(
                        fn (Collection $records) => "Delete {$records->count()} selected ".str('rank group')->plural($records->count()).'?'
                    )
                    ->modalSubheading(function (Collection $records) {
                        $statement = ($records->count() === 1)
                            ? 'this 1 rank group'
                            : "these {$records->count()} rank groups";

                        $notice = ($records->count() === 1) ? 'it' : 'them';

                        return "Are you sure you want to delete {$statement}? You won't be able to recover {$notice}. This will also delete all ranks within the group(s) and any characters with those ranks will need to have new ranks assigned to them.";
                    })
                    ->modalSubmitActionLabel('Delete')
                    ->successNotificationTitle('Rank groups were deleted')
                    ->using(fn (Collection $records) => $records->each(
                        fn (Model $record) => DeleteRankGroup::run($record)
                    )),
            ])
            ->filters([
                TernaryFilter::make('assigned_ranks')
                    ->label('Has assigned ranks')
                    ->queries(
                        true: fn (Builder $query) => $query->whereHas('ranks'),
                        false: fn (Builder $query) => $query->whereDoesntHave('ranks')
                    ),
                SelectFilter::make('status')->options(RankGroupStatus::class),
            ])
            ->reorderable('order_column')
            ->heading('Rank groups')
            ->description('Collections of related rank items for simpler searching and selecting')
            ->headerActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add')
                    ->url(route('ranks.groups.create')),
            ])
            ->header(fn () => $this->isTableReordering() ? view('filament.tables.reordering-notice') : null)
            ->emptyStateIcon(iconName('list'))
            ->emptyStateHeading('No rank groups found')
            ->emptyStateDescription('Rank groups are a simple way to collect related rank items together for simpler searching and selecting ranks in Nova.')
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add a rank group')
                    ->url(route('ranks.groups.create')),
            ]);
    }

    public function render()
    {
        return view('livewire.filament-table');
    }
}
