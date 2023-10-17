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
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Url;
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
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Livewire\TableComponent;

class PositionsList extends TableComponent
{
    #[Url]
    public ?array $tableFilters = [
        'department_id',
    ];

    public function table(Table $table): Table
    {
        return $table
            ->query(Position::with('department', 'activeCharacters', 'activeUsers'))
            ->groups([
                Group::make('department.name')->label('Department name')->collapsible(),
                Group::make('department.order_column')
                    ->label('Department order')
                    ->getTitleFromRecordUsing(fn (Model $record): string => $record->department->name)
                    ->collapsible(),
            ])
            ->defaultGroup('department.order_column')
            ->defaultSort('order_column', 'asc')
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
                    ->counts([
                        'activeUsers' => fn (Builder $query): Builder => $query->countDistinct(),
                    ])
                    ->label('Playing users')
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
                            ->url(fn (Model $record): string => route('positions.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Model $record): string => route('positions.edit', $record)),
                    ])->authorizeAny(['view', 'update'])->divided(),

                    ActionGroup::make([
                        ReplicateAction::make()
                            ->form([
                                TextInput::make('name')->label('New position name'),
                                Select::make('department_id')->relationship('department', 'name'),
                            ])
                            ->modalContentView('pages.positions.duplicate')
                            ->action(function (Model $record, array $data): void {
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
                            ->modalContentView('pages.positions.delete')
                            ->successNotificationTitle(fn (Model $record): string => $record->name.' position was deleted')
                            ->using(fn (Model $record): Model => DeletePosition::run($record)),
                    ])->authorize('delete')->divided(),
                ]),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->authorize('deleteAny')
                    ->modalContentView('pages.positions.delete-bulk')
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
                            ->each(fn (Model $record): Model => DeletePosition::run($record));

                        Notification::make()->success()
                            ->title(count($records).' '.trans_choice('position was|positions were', count($records)).' deleted')
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
                SelectFilter::make('department_id')
                    ->relationship('department', 'name')
                    ->label('Department')
                    ->multiple()
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
                SelectFilter::make('status')->options(PositionStatus::class),
            ])
            ->heading('Positions')
            ->description('The jobs or stations characters are assigned to for display on your manifests')
            ->headerActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add')
                    ->url(route('positions.create')),
            ])
            ->header(fn (): ?View => $this->isTableReordering() ? view('filament.tables.positions-reordering-notice') : null)
            ->reorderable('order_column')
            ->emptyStateIcon(iconName('list'))
            ->emptyStateHeading('No positions found')
            ->emptyStateDescription('Positions are the jobs or stations that characters can be assigned to for display on your manifests.')
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add a position')
                    ->url(route('positions.create')),
            ]);
    }
}
