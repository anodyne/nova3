<?php

declare(strict_types=1);

namespace Nova\Departments\Livewire;

use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Nova\Departments\Actions\DeleteDepartment;
use Nova\Departments\Actions\DuplicateDepartment;
use Nova\Departments\Data\DepartmentData;
use Nova\Departments\Enums\DepartmentStatus;
use Nova\Departments\Events\DepartmentDuplicated;
use Nova\Departments\Models\Department;
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

class DepartmentsList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(Department::with('positions'))
            ->defaultSort('order_column', 'asc')
            ->reorderable('order_column')
            ->columns([
                TextColumn::make('name')
                    ->titleColumn()
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query->searchFor($search))
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
                        'activeUsers' => fn (Builder $query): Builder => $query->countDistinct(),
                    ])
                    ->label('# of users')
                    ->alignCenter()
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
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
                            ->url(fn (Model $record): string => route('departments.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Model $record): string => route('departments.edit', $record)),
                    ])->authorizeAny(['view', 'update'])->divided(),

                    ActionGroup::make([
                        Action::make('positions')
                            ->authorize('viewAny', Position::class)
                            ->icon(iconName('list'))
                            ->url(fn (Model $record): string => route('positions.index', ['tableFilters' => ['department_id' => ['values' => [$record->id]]]])),
                    ])->authorize('viewAny', Position::class)->divided(),

                    ActionGroup::make([
                        ReplicateAction::make()
                            ->authorize('duplicate')
                            ->form([
                                TextInput::make('name')->label('New department name'),
                            ])
                            ->modalContentView('pages.departments.duplicate')
                            ->action(function (Model $record, array $data): void {
                                $replica = DuplicateDepartment::run(
                                    $record,
                                    DepartmentData::from(array_merge($record->toArray(), $data))
                                );

                                DepartmentDuplicated::dispatch($replica, $record);

                                Notification::make()->success()
                                    ->title("{$replica->name} department has been created")
                                    ->body("All of the positions from the {$record->name} department have been duplicated into your new department.")
                                    ->send();
                            }),
                    ])->authorize('duplicate')->divided(),

                    ActionGroup::make([
                        DeleteAction::make()
                            ->authorize('delete')
                            ->modalContentView('pages.departments.delete')
                            ->successNotificationTitle(fn (Model $record): string => $record->name.' department was deleted')
                            ->using(fn (Model $record): Model => DeleteDepartment::run($record)),
                    ])->authorize('delete')->divided(),
                ]),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->authorize('deleteAny')
                    ->modalContentView('pages.departments.delete-bulk')
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
                            ->each(fn (Model $record): Model => DeleteDepartment::run($record));

                        Notification::make()->success()
                            ->title(count($records).' '.trans_choice('department was|departments were', count($records)).' deleted')
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
                TernaryFilter::make('has_positions')
                    ->queries(
                        true: fn (Builder $query) => $query->whereHas('positions'),
                        false: fn (Builder $query) => $query->whereDoesntHave('positions')
                    ),
                SelectFilter::make('status')->options(DepartmentStatus::class),
            ])
            ->header(fn (): ?View => $this->isTableReordering() ? view('filament.tables.reordering-notice') : null)
            ->emptyStateIcon(iconName('list'))
            ->emptyStateHeading('No departments found')
            ->emptyStateDescription('Departments allow you to organize character positions into logical groups that you can display on your manifests.')
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add a department')
                    ->url(route('departments.create')),
            ]);
    }
}
