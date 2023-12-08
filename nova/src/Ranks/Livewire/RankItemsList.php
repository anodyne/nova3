<?php

declare(strict_types=1);

namespace Nova\Ranks\Livewire;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Ranks\Actions\DeleteRankItemManager;
use Nova\Ranks\Enums\RankItemStatus;
use Nova\Ranks\Models\RankItem;

class RankItemsList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(RankItem::query()->withRankName())
            ->defaultSort('order_column', 'asc')
            ->groups([
                Group::make('group.name')->label('Rank group')->collapsible(),
                Group::make('name.name')->label('Rank name')->collapsible(),
            ])
            ->defaultGroup('group.name')
            ->columns([
                ViewColumn::make('name')
                    ->view('filament.tables.columns.rank')
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query->searchFor($search))
                    ->sortable(),
                TextColumn::make('characters_count')
                    ->counts('characters')
                    ->label('# of characters')
                    ->alignCenter()
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
                            ->url(fn (Model $record): string => route('ranks.items.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Model $record): string => route('ranks.items.edit', $record)),
                    ])->authorizeAny(['view', 'update'])->divided(),

                    ActionGroup::make([
                        DeleteAction::make()
                            ->authorize('delete')
                            ->modalContentView('pages.ranks.items.delete')
                            ->successNotificationTitle(fn (Model $record): string => $record->name->name.' rank item was deleted')
                            ->using(fn (Model $record): Model => DeleteRankItemManager::run($record)),
                    ])->authorize('delete')->divided(),
                ]),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->authorize('deleteAny')
                    ->modalContentView('pages.ranks.items.delete-bulk')
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
                            ->each(fn (Model $record): Model => DeleteRankItemManager::run($record));

                        Notification::make()->success()
                            ->title(count($records).' '.trans_choice('rank item was|rank items were', count($records)).' deleted')
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
                SelectFilter::make('group_id')
                    ->relationship('group', 'name')
                    ->multiple()
                    ->label('Rank group'),
                SelectFilter::make('name_id')
                    ->relationship('name', 'name')
                    ->multiple()
                    ->label('Rank name'),
                SelectFilter::make('status')->options(RankItemStatus::class),
            ])
            ->reorderable('order_column')
            ->heading('Rank items')
            ->description("Combine the rank group, rank name, and rank images to define your game's ranks")
            ->headerActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add')
                    ->url(route('ranks.items.create')),
            ])
            ->header(fn (): ?View => $this->isTableReordering() ? view('filament.tables.reordering-notice') : null)
            ->emptyStateIcon(iconName('rank'))
            ->emptyStateHeading('No ranks found')
            ->emptyStateDescription('Rank items bring the rank group, rank name, and images together in a simple and easy-to-use rank experience.')
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add a rank')
                    ->url(route('ranks.items.create')),
            ]);
    }
}
