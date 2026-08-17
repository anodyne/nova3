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
use Nova\Ranks\Actions\DeleteRankGroupManager;
use Nova\Ranks\Actions\DuplicateRankGroup;
use Nova\Ranks\Concerns\FindRankImages;
use Nova\Ranks\Data\RankGroupData;
use Nova\Ranks\Events\RankGroupDuplicated;
use Nova\Ranks\Models\Builders\RankGroupBuilder;
use Nova\Ranks\Models\RankGroup;
use Nova\Users\Models\User;
use RalphJSmit\Filament\Activitylog\Filament\Actions\TimelineAction;
use RalphJSmit\Filament\Activitylog\Filament\Infolists\Components\Timeline;
use Spatie\Activitylog\Models\Activity;

class RankGroupsList extends TableComponent
{
    use FindRankImages;

    public function table(Table $table): Table
    {
        return $table
            ->query(RankGroup::query())
            ->recordUrl(fn (RankGroup $record): string => route('admin.ranks.groups.show', $record))
            ->defaultSort('order_column', 'asc')
            ->reorderable('order_column')
            ->columns([
                TextColumn::make('name')
                    ->titleColumn()
                    ->searchable(query: fn (RankGroupBuilder $query, string $search): RankGroupBuilder => $query->searchFor($search))
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
                            ->url(fn (RankGroup $record): string => route('admin.ranks.groups.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (RankGroup $record): string => route('admin.ranks.groups.edit', $record)),
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

                                            return __('activity.ranks.group-duplicated', [
                                                'name' => $causerName,
                                                'rankGroup' => RankGroup::find(
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
                                TextInput::make('name')->label('New rank group name'),
                                Select::make('base_image')
                                    ->label('New base image')
                                    ->placeholder('Select a base image')
                                    ->options($this->getRankBaseImages()),
                            ])
                            ->recordDisplayNameAttribute('name')
                            ->modalContentView('pages.ranks.groups.duplicate')
                            ->action(function (RankGroup $record, array $data): void {
                                $replica = DuplicateRankGroup::run(
                                    $record,
                                    RankGroupData::from(
                                        name: data_get($data, 'name'),
                                        status: $record->status,
                                        base_image: data_get($data, 'base_image')
                                    )
                                );

                                RankGroupDuplicated::dispatch($replica, $record);
                            }),
                    ])->divided(),

                    ActionGroup::make([
                        DeleteAction::make()
                            ->authorize('delete')
                            ->modalContentView('pages.ranks.groups.delete')
                            ->successNotificationTitle(fn (RankGroup $record): string => $record->name.' rank group was deleted')
                            ->using(fn (RankGroup $record): Model => DeleteRankGroupManager::run($record)),
                    ])->divided(),
                ]),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->authorize('deleteAny')
                    ->modalContentView('pages.ranks.groups.delete-bulk')
                    ->action(function (Collection $records): void {
                        $records->each(fn (RankGroup $record): Model => DeleteRankGroupManager::run($record));
                    }),
            ])
            ->filters([
                TernaryFilter::make('ranks_assigned')
                    ->label('Has ranks assigned')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->whereHas('ranks'),
                        false: fn (Builder $query): Builder => $query->whereDoesntHave('ranks')
                    ),
                SelectFilter::make('status')->options(BasicStatus::class),
            ])
            ->header(fn (): ?View => $this->isTableReordering() ? view('filament.tables.reordering-notice') : null)
            ->emptyStateIcon(Illustration::Layers)
            ->emptyStateHeading('No rank groups found')
            ->emptyStateDescription('Rank groups are a simple way to collect related rank items together for simpler searching and selecting ranks in Nova.')
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add a rank group')
                    ->url(route('admin.ranks.groups.create')),
            ]);
    }
}
