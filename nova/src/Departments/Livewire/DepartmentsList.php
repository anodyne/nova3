<?php

declare(strict_types=1);

namespace Nova\Departments\Livewire;

use Anodyne\TablerIcons\Tabler;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Nova\Departments\Actions\DeleteDepartment;
use Nova\Departments\Actions\DuplicateDepartment;
use Nova\Departments\Data\DepartmentData;
use Nova\Departments\Events\DepartmentDuplicated;
use Nova\Departments\Models\Builders\DepartmentBuilder;
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
use Nova\Foundation\Livewire\TableComponent;
use Nova\Users\Models\Builders\UserBuilder;
use Nova\Users\Models\User;
use RalphJSmit\Filament\Activitylog\Filament\Actions\TimelineAction;
use RalphJSmit\Filament\Activitylog\Filament\Infolists\Components\Timeline;
use Spatie\Activitylog\Models\Activity;

class DepartmentsList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Department::with('positions')
                    ->select([
                        'id',
                        'name',
                        'order_column',
                        'status',
                    ])
            )
            ->recordUrl(fn (Department $record): string => route('admin.departments.show', $record))
            ->defaultSort('order_column', 'asc')
            ->reorderable('order_column')
            ->columns([
                TextColumn::make('name')
                    ->titleColumn()
                    ->searchable(query: fn (DepartmentBuilder $query, string $search): DepartmentBuilder => $query->searchFor($search))
                    ->sortable(),
                TextColumn::make('positions_count')
                    ->counts('positions')
                    ->label('# of positions')
                    ->alignCenter()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('active_characters_count')
                    ->counts('activeCharacters')
                    ->label('# of characters')
                    ->alignCenter()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('active_users_count')
                    ->counts([
                        'activeUsers' => fn (UserBuilder $query): UserBuilder => $query->countDistinct(),
                    ])
                    ->label('# of users')
                    ->alignCenter()
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('status')
                    ->badge()
                    ->toggleable(),
            ])
            ->recordActions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make()
                            ->authorize('view')
                            ->url(fn (Department $record): string => route('admin.departments.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Department $record): string => route('admin.departments.edit', $record)),
                    ])->divided(),

                    ActionGroup::make([
                        TimelineAction::make()
                            ->modifyTimelineUsing(function (Timeline $timeline) {
                                $timeline
                                    ->attributeValues([
                                        'tags' => fn ($value) => is_array($value) ? implode(', ', $value) : '',
                                    ])
                                    ->eventDescriptions([
                                        'duplicated' => fn (Activity $activity) => __('activity.departments.duplicated', [
                                            'name' => $activity->causer instanceof User ? $activity->causer->name : 'System',
                                            'replica' => Department::find($activity->getExtraProperty('replica'))?->name,
                                        ]),
                                        'uploaded' => fn (Activity $activity) => __('activity.departments.uploaded', [
                                            'name' => $activity->causer instanceof User ? $activity->causer->name : 'System',
                                        ]),
                                    ]);
                            }),
                    ])->divided(),

                    ActionGroup::make([
                        Action::make('positions')
                            ->authorize('viewAny', Position::class)
                            ->icon(Tabler::List)
                            ->url(fn (Department $record): string => route('admin.positions.index', ['tableFilters' => ['department_id' => ['values' => [$record->id]]]])),
                    ])->divided(),

                    ActionGroup::make([
                        ReplicateAction::make()
                            ->authorize('duplicate')
                            ->schema([
                                TextInput::make('name')
                                    ->label('New department name')
                                    ->required(),
                            ])
                            ->modalContentView('pages.departments.duplicate')
                            ->action(function (Department $record, array $data): void {
                                $department = Department::find($record->id);

                                $replica = DuplicateDepartment::run(
                                    $department,
                                    DepartmentData::from(
                                        name: data_get($data, 'name'),
                                        description: $department->description,
                                        tags: $department->tags ?? [],
                                        status: $department->status
                                    )
                                );

                                DepartmentDuplicated::dispatch($replica, $department);
                            }),
                    ])->divided(),

                    ActionGroup::make([
                        DeleteAction::make()
                            ->authorize('delete')
                            ->modalContentView('pages.departments.delete')
                            ->successNotificationTitle(fn (Department $record): string => $record->name.' department was deleted')
                            ->using(fn (Department $record): Model => DeleteDepartment::run($record)),
                    ])->divided(),
                ]),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->authorizeIndividualRecords('delete')
                    ->modalContentView('pages.departments.delete-bulk')
                    ->action(function (Collection $records): void {
                        $records->each(fn (Department $record): Model => DeleteDepartment::run($record));
                    }),
            ])
            ->filters([
                TernaryFilter::make('has_positions')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->whereHas('positions'),
                        false: fn (Builder $query): Builder => $query->whereDoesntHave('positions')
                    ),
                SelectFilter::make('status')->options(BasicStatus::class),
            ])
            ->header(fn (): ?View => $this->isTableReordering() ? view('filament.tables.reordering-notice') : null)
            ->emptyStateIcon(Tabler::List)
            ->emptyStateHeading('No departments found')
            ->emptyStateDescription('Departments allow you to organize character positions into logical groups that you can display on your manifests.')
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add a department')
                    ->url(route('admin.departments.create')),
            ]);
    }
}
