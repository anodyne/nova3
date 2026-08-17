<?php

declare(strict_types=1);

namespace Nova\Ranks\Livewire;

use Anodyne\TablerIcons\Tabler;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Ranks\Actions\DeleteRankItemManager;
use Nova\Ranks\Models\Builders\RankItemBuilder;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankName;
use RalphJSmit\Filament\Activitylog\Filament\Actions\TimelineAction;
use RalphJSmit\Filament\Activitylog\Filament\Infolists\Components\Timeline;

class RankItemsList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(RankItem::query()->withRankName())
            ->recordUrl(fn (RankItem $record): string => route('admin.ranks.items.show', $record))
            ->groups([
                Group::make('group.name')->label('Rank group')->collapsible(),
                Group::make('name.name')->label('Rank name')->collapsible(),
            ])
            ->defaultGroup('group.name')
            ->defaultSort('order_column', 'asc')
            ->reorderable('order_column')
            ->defaultPaginationPageOption(25)
            ->columns([
                ViewColumn::make('name')
                    ->view('filament.tables.columns.rank')
                    ->searchable(query: fn (RankItemBuilder $query, string $search): RankItemBuilder => $query->searchFor($search))
                    ->sortable(),
                TextColumn::make('characters_count')
                    ->counts('characters')
                    ->label('# of characters')
                    ->alignCenter()
                    ->toggleable(),
                TextColumn::make('status')
                    ->badge()
                    ->toggleable(),
            ])
            ->recordActions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make()
                            ->authorize('view')
                            ->url(fn (RankItem $record): string => route('admin.ranks.items.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (RankItem $record): string => route('admin.ranks.items.edit', $record)),
                    ])->divided(),

                    ActionGroup::make([
                        TimelineAction::make()
                            ->modifyTimelineUsing(function (Timeline $timeline) {
                                $timeline
                                    ->attributeLabels([
                                        'group_id' => 'rank group',
                                        'name_id' => 'rank name',
                                    ])
                                    ->attributeValues([
                                        'group_id' => fn ($value) => RankGroup::find($value)?->name,
                                        'name_id' => fn ($value) => RankName::find($value)?->name,
                                    ]);
                            }),
                    ])->divided(),

                    ActionGroup::make([
                        DeleteAction::make()
                            ->authorize('delete')
                            ->modalContentView('pages.ranks.items.delete')
                            ->successNotificationTitle(fn (RankItem $record): string => $record->name->name.' rank item was deleted')
                            ->using(fn (RankItem $record): Model => DeleteRankItemManager::run($record)),
                    ])->divided(),
                ]),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->authorize('deleteAny')
                    ->modalContentView('pages.ranks.items.delete-bulk')
                    ->action(function (Collection $records): void {
                        $ignoredRecords = 0;

                        $records = $records
                            ->filter(function (RankItem $record) use (&$ignoredRecords): bool {
                                if (Gate::allows('delete', $record)) {
                                    return true;
                                }

                                $ignoredRecords += 1;

                                return false;
                            })
                            ->each(fn (RankItem $record): Model => DeleteRankItemManager::run($record));

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
                SelectFilter::make('status')->options(BasicStatus::class),
            ])
            ->header(fn (): ?View => $this->isTableReordering() ? view('filament.tables.reordering-notice') : null)
            ->emptyStateIcon(Tabler::MilitaryRank)
            ->emptyStateHeading('No ranks found')
            ->emptyStateDescription('Rank items bring the rank group, rank name, and images together in a simple and easy-to-use rank experience.')
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add a rank')
                    ->url(route('admin.ranks.items.create')),
            ]);
    }
}
