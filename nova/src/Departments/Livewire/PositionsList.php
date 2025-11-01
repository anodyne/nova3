<?php

declare(strict_types=1);

namespace Nova\Departments\Livewire;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Livewire\Attributes\Url;
use Nova\Departments\Actions\DeletePosition;
use Nova\Departments\Actions\DuplicatePosition;
use Nova\Departments\Data\PositionData;
use Nova\Departments\Events\PositionDuplicated;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
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
use RalphJSmit\Filament\Activitylog\Filament\Actions\TimelineAction;
use RalphJSmit\Filament\Activitylog\Filament\Infolists\Components\Timeline;
use Spatie\Activitylog\Models\Activity;

class PositionsList extends TableComponent
{
    #[Url]
    public ?array $tableFilters = [
        'department_id',
    ];

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Position::with('department', 'activeCharacters', 'activeUsers')
                    ->select([
                        'available',
                        'department_id',
                        'positions.id',
                        'positions.name',
                        'positions.order_column',
                        'positions.status',
                    ])
            )
            ->recordUrl(fn (Position $record): string => route('admin.positions.show', $record))
            ->groups([
                Group::make('department.name')->label('Department name')->collapsible(),
                Group::make('department.order_column')
                    ->label('Department order')
                    ->getTitleFromRecordUsing(fn (Position $record): string => $record->department->name)
                    ->collapsible(),
            ])
            ->defaultGroup('department.order_column')
            ->defaultSort('order_column', 'asc')
            ->reorderable('order_column')
            ->columns([
                TextColumn::make('name')
                    ->titleColumn()
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query->searchFor($search))
                    ->sortable(),
                TextColumn::make('available')
                    ->label('Available slots')
                    ->alignCenter()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('active_characters_count')
                    ->counts('activeCharacters')
                    ->label('Assigned characters')
                    ->alignCenter()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('active_users_count')
                    ->label('Playing users')
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
                            ->url(fn (Position $record): string => route('admin.positions.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Position $record): string => route('admin.positions.edit', $record)),
                    ])->divided(),

                    ActionGroup::make([
                        TimelineAction::make()
                            ->modifyTimelineUsing(function (Timeline $timeline) {
                                $timeline
                                    ->attributeLabels([
                                        'available' => 'availability',
                                        'department_id' => 'department',
                                    ])
                                    ->attributeValues([
                                        'department_id' => fn ($value) => Department::find($value)?->name,
                                        'tags' => fn ($value) => is_array($value) ? implode(', ', $value) : '',
                                    ])
                                    ->eventDescriptions([
                                        'duplicated' => fn (Activity $activity) => __('activity.positions.duplicated', [
                                            'name' => $activity->causer->name,
                                            'replica' => Position::find($activity->getExtraProperty('replica'))?->name,
                                        ]),
                                    ]);
                            }),
                    ])->divided(),

                    ActionGroup::make([
                        ReplicateAction::make()
                            ->authorize('duplicate')
                            ->schema([
                                TextInput::make('name')
                                    ->label('New position name')
                                    ->required(),
                                Select::make('department_id')
                                    ->relationship('department', 'name')
                                    ->required(),
                            ])
                            ->modalContentView('pages.positions.duplicate')
                            ->action(function (Position $record, array $data): void {
                                $position = Position::find($record->id);

                                $replica = DuplicatePosition::run(
                                    $position,
                                    PositionData::from(
                                        name: data_get($data, 'name'),
                                        description: $position->description,
                                        available: $position->available,
                                        tags: $position->tags ?? [],
                                        status: $position->status,
                                        department_id: data_get($data, 'department_id')
                                    )
                                );

                                PositionDuplicated::dispatch($replica, $position);
                            }),
                    ])->divided(),

                    ActionGroup::make([
                        DeleteAction::make()
                            ->authorize('delete')
                            ->modalContentView('pages.positions.delete')
                            ->successNotificationTitle(fn (Position $record): string => $record->name.' position was deleted')
                            ->using(fn (Position $record): Model => DeletePosition::run($record)),
                    ])->divided(),
                ]),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->authorizeIndividualRecords('delete')
                    ->modalContentView('pages.positions.delete-bulk')
                    ->action(function (Collection $records): void {
                        $records->each(fn (Position $record): Model => DeletePosition::run($record));
                    }),
            ])
            ->filters([
                SelectFilter::make('department_id')
                    ->relationship('department', 'name')
                    ->label('Department')
                    ->multiple()
                    ->preload()
                    ->searchable(),
                TernaryFilter::make('available')
                    ->label('Has available slots')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->where('available', '>', 0),
                        false: fn (Builder $query): Builder => $query->where('available', '<', 1)
                    ),
                TernaryFilter::make('assigned_characters')
                    ->label('Has assigned characters')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->whereHas('activeCharacters'),
                        false: fn (Builder $query): Builder => $query->whereDoesntHave('activeCharacters')
                    ),
                SelectFilter::make('status')->options(BasicStatus::class),
            ])
            ->header(fn (): ?View => $this->isTableReordering() ? view('filament.tables.positions-reordering-notice') : null)
            ->emptyStateIcon(Illustration::HandpickResume)
            ->emptyStateHeading('No positions found')
            ->emptyStateDescription('Positions are the jobs or stations that characters can be assigned to for display on your manifests.')
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add a position')
                    ->url(route('admin.positions.create')),
            ]);
    }
}
