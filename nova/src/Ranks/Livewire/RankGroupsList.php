<?php

declare(strict_types=1);

namespace Nova\Ranks\Livewire;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ReplicateAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Ranks\Actions\DeleteRankGroupManager;
use Nova\Ranks\Actions\DuplicateRankGroup;
use Nova\Ranks\Concerns\FindRankImages;
use Nova\Ranks\Data\RankGroupData;
use Nova\Ranks\Enums\RankGroupStatus;
use Nova\Ranks\Events\RankGroupDuplicated;
use Nova\Ranks\Models\RankGroup;

class RankGroupsList extends TableComponent
{
    use FindRankImages;

    public function table(Table $table): Table
    {
        return $table
            ->query(RankGroup::query())
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
                    ->color(fn (Model $record): string => $record->status->color())
                    ->toggleable(),
            ])
            ->actions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make()
                            ->authorize('view')
                            ->url(fn (Model $record): string => route('ranks.groups.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Model $record): string => route('ranks.groups.edit', $record)),
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
                            ->modalContentView('pages.ranks.groups.duplicate')
                            ->action(function (Model $record, array $data): void {
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
                            ->modalContentView('pages.ranks.groups.delete')
                            ->successNotificationTitle(fn (Model $record): string => $record->name.' rank group was deleted')
                            ->using(fn (Model $record): Model => DeleteRankGroupManager::run($record)),
                    ])->authorize('delete')->divided(),
                ]),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->authorize('deleteAny')
                    ->modalContentView('pages.ranks.groups.delete-bulk')
                    ->action(function (Collection $records): void {
                        $ignoredRecords = 0;

                        $records = $records
                            ->filter(function (Model $record) use (&$ignoredRecords): bool {
                                if (Gate::allows('delete', $record)) {
                                    return true;
                                }

                                $ignoredRecords += 1;

                                return false;
                            })
                            ->each(fn (Model $record): Model => DeleteRankGroupManager::run($record));

                        Notification::make()->success()
                            ->title(count($records).' '.trans_choice('rank group was|rank groups were', count($records)).' deleted')
                            ->when($ignoredRecords > 0, function (Notification $notification) use ($ignoredRecords) {
                                return $notification->body(sprintf(
                                    '%d %s ignored due to being ineligible for this action.',
                                    $ignoredRecords,
                                    trans_choice('record was|records were', $ignoredRecords)
                                ));
                            })
                            ->send();
                    }),
            ])
            ->filters([
                TernaryFilter::make('ranks_assigned')
                    ->label('Has ranks assigned')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->whereHas('ranks'),
                        false: fn (Builder $query): Builder => $query->whereDoesntHave('ranks')
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
            ->header(fn (): ?View => $this->isTableReordering() ? view('filament.tables.reordering-notice') : null)
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
}
