<?php

declare(strict_types=1);

namespace Nova\Departments\Livewire;

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
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Livewire\Component;
use Nova\Departments\Actions\DeletePosition;
use Nova\Departments\Actions\DuplicatePosition;
use Nova\Departments\Data\PositionData;
use Nova\Departments\Enums\PositionStatus;
use Nova\Departments\Events\PositionDuplicated;
use Nova\Departments\Models\Position;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ReplicateAction;
use Nova\Foundation\Filament\Actions\ViewAction;

class PositionsList extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Position::with('department'))
            ->groups([
                Group::make('department.name')->collapsible(),
            ])
            ->defaultGroup('department.name')
            ->defaultSort('order_column', 'asc')
            ->columns([
                TextColumn::make('name')
                    ->titleColumn()
                    ->searchable(query: fn (Builder $query, string $search) => $query->searchFor($search))
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
                            ->url(fn (Model $record) => route('positions.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Model $record) => route('positions.edit', $record)),
                    ])->authorizeAny(['view', 'update'])->divided(),
                    ActionGroup::make([
                        ReplicateAction::make()
                            ->form([
                                TextInput::make('name')->label('New position name'),
                                Select::make('department_id')->relationship('department', 'name'),
                            ])
                            ->modalHeading('Duplicate position?')
                            ->modalSubheading(
                                fn (Model $record) => "Are you sure you want to duplicate the {$record->name} position?"
                            )
                            ->modalSubmitActionLabel('Duplicate')
                            ->action(function (Model $record, array $data) {
                                $replica = DuplicatePosition::run(
                                    $record,
                                    PositionData::from(array_merge($record->toArray(), $data))
                                );

                                PositionDuplicated::dispatch($replica, $record);

                                Notification::make()->success()
                                    ->title("{$replica->name} has been created")
                                    ->body("All of the data from {$record->name} has been duplicated into your new position.")
                                    ->send();
                            }),
                    ])->authorize('duplicate')->divided(),
                    ActionGroup::make([
                        DeleteAction::make()
                            ->modalHeading('Delete position?')
                            ->modalSubheading(
                                fn (Model $record) => "Are you sure you want to delete the {$record->name} position from the {$record->department->name} department? You won't be able to recover it. Any characters assigned to this position will need to be re-assigned to another position."
                            )
                            ->modalSubmitActionLabel('Delete')
                            ->successNotificationTitle('Position was deleted')
                            ->using(fn (Model $record) => DeletePosition::run($record)),
                    ])->authorize('delete')->divided(),
                ]),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->authorize('deleteAny')
                    ->modalHeading(
                        fn (Collection $records) => "Delete {$records->count()} selected ".str('position')->plural($records->count()).'?'
                    )
                    ->modalSubheading(function (Collection $records) {
                        $statement = ($records->count() === 1)
                            ? 'this 1 position'
                            : "these {$records->count()} positions";

                        $notice = ($records->count() === 1) ? 'it' : 'them';

                        return "Are you sure you want to delete {$statement}? You won't be able to recover {$notice}. Any characters assigned to {$statement} will need to be re-assigned to other positions.";
                    })
                    ->modalSubmitActionLabel('Delete')
                    ->successNotificationTitle('Positions were deleted')
                    ->using(fn (Collection $records) => $records->each(
                        fn (Model $record) => DeletePosition::run($record)
                    )),
            ])
            ->filters([
                SelectFilter::make('department_id')
                    ->relationship('department', 'name')
                    ->label('Department')
                    ->multiple()
                    ->searchable(),
                TernaryFilter::make('available')
                    ->label('Has available slots')
                    ->queries(
                        true: fn (Builder $query) => $query->where('available', '>', 0),
                        false: fn (Builder $query) => $query->where('available', '<', 1)
                    ),
                TernaryFilter::make('assigned_characters')
                    ->label('Has assigned characters')
                    ->queries(
                        true: fn (Builder $query) => $query->whereHas('activeCharacters'),
                        false: fn (Builder $query) => $query->whereDoesntHave('activeCharacters')
                    ),
                SelectFilter::make('status')->options(PositionStatus::class),
            ])
            ->heading('Positions')
            ->description("The jobs or stations characters are assigned to for display on your manifests")
            ->headerActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add')
                    ->url(route('positions.create')),
            ])
            ->header(fn () => $this->isTableReordering() ? view('filament.tables.positions-reordering-notice') : null)
            ->reorderable('order_column')
            ->emptyStateIcon(iconName('list'))
            ->emptyStateHeading('No positions found')
            ->emptyStateDescription("Positions are the jobs or stations that characters can be assigned to for display on your manifests.")
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add a position')
                    ->url(route('positions.create')),
            ]);
    }

    public function render()
    {
        return view('livewire.filament-table');
    }
}