<?php

declare(strict_types=1);

namespace Nova\Ranks\Livewire;

use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ReplicateAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Foundation\Icons\Illustration;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Ranks\Actions\DeleteRankNameManager;
use Nova\Ranks\Actions\DuplicateRankName;
use Nova\Ranks\Data\RankNameData;
use Nova\Ranks\Events\RankNameDuplicated;
use Nova\Ranks\Models\Builders\RankNameBuilder;
use Nova\Ranks\Models\RankName;
use Nova\Users\Models\User;
use RalphJSmit\Filament\Activitylog\Filament\Actions\TimelineAction;
use RalphJSmit\Filament\Activitylog\Filament\Infolists\Components\Timeline;
use Spatie\Activitylog\Models\Activity;

class RankNamesList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(RankName::query())
            ->recordUrl(fn (RankName $record): string => route('admin.ranks.names.show', $record))
            ->defaultSort('order_column', 'asc')
            ->reorderable('order_column')
            ->columns([
                TextColumn::make('name')
                    ->titleColumn()
                    ->searchable(query: fn (RankNameBuilder $query, string $search): RankNameBuilder => $query->searchFor($search))
                    ->sortable(),
                TextColumn::make('ranks_count')
                    ->counts('ranks')
                    ->label('# of ranks')
                    ->alignCenter()
                    ->sortable()
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
                            ->url(fn (RankName $record): string => route('admin.ranks.names.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (RankName $record): string => route('admin.ranks.names.edit', $record)),
                    ])->divided(),

                    ActionGroup::make([
                        TimelineAction::make()
                            ->modifyTimelineUsing(function (Timeline $timeline) {
                                $timeline
                                    ->eventDescriptions([
                                        'duplicated' => function (Activity $activity) {
                                            $causer = $activity->causer;
                                            $causerName = $causer instanceof User
                                                ? $causer->name
                                                : 'System';

                                            return __('activity.ranks.name-duplicated', [
                                                'name' => $causerName,
                                                'rankName' => RankName::find(
                                                    $activity->getExtraProperty('replica')
                                                )?->name,
                                            ]);
                                        },
                                    ]);
                            }),
                    ])->divided(),

                    ActionGroup::make([
                        ReplicateAction::make()
                            ->authorize('duplicate')
                            ->schema([
                                TextInput::make('name')->label('New rank name'),
                            ])
                            ->recordDisplayNameAttribute('name')
                            ->modalContentView('pages.ranks.names.duplicate')
                            ->action(function (RankName $record, array $data): void {
                                $replica = DuplicateRankName::run(
                                    $record,
                                    RankNameData::from(
                                        name: data_get($data, 'name'),
                                        status: $record->status
                                    )
                                );

                                RankNameDuplicated::dispatch($replica, $record);
                            }),
                    ])->divided(),

                    ActionGroup::make([
                        DeleteAction::make()
                            ->authorize('delete')
                            ->modalContentView('pages.ranks.names.delete')
                            ->successNotificationTitle(fn (RankName $record): string => $record->name.' rank name was deleted')
                            ->using(fn (RankName $record): Model => DeleteRankNameManager::run($record)),
                    ])->divided(),
                ]),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->authorize('deleteAny')
                    ->modalContentView('pages.ranks.names.delete-bulk')
                    ->action(function (Collection $records): void {
                        $records->each(fn (RankName $record): Model => DeleteRankNameManager::run($record));
                    }),
            ])
            ->filters([
                TernaryFilter::make('ranks_assigned')
                    ->label('Has assigned ranks')
                    ->queries(
                        true: fn (RankNameBuilder $query): RankNameBuilder => $query->whereHas('ranks'),
                        false: fn (RankNameBuilder $query): RankNameBuilder => $query->whereDoesntHave('ranks')
                    ),
                SelectFilter::make('status')->options(BasicStatus::class),
            ])
            ->header(fn (): ?View => $this->isTableReordering() ? view('filament.tables.reordering-notice') : null)
            ->emptyStateIcon(Illustration::ClipboardList)
            ->emptyStateHeading('No rank names found')
            ->emptyStateDescription('Rank names eliminate the repetitive task of setting the name of a rank by letting you re-use names across all of your rank items.')
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add a rank name')
                    ->url(route('admin.ranks.names.create')),
            ]);
    }
}
