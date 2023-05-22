<?php

declare(strict_types=1);

namespace Nova\Departments\Livewire;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Livewire\Component;
use Nova\Departments\Actions\DeleteDepartment;
use Nova\Departments\Actions\DuplicateDepartmentManager;
use Nova\Departments\Enums\DepartmentStatus;
use Nova\Departments\Events\DepartmentDuplicated;
use Nova\Departments\Models\Department;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ReplicateAction;
use Nova\Foundation\Filament\Actions\ViewAction;

class DepartmentsList extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Department::query())
            ->defaultSort('order_column', 'asc')
            ->columns([
                TextColumn::make('name')
                    ->titleColumn()
                    ->searchable(query: fn (Builder $query, string $search) => $query->searchFor($search))
                    ->sortable(),
                TextColumn::make('positions_count')
                    ->counts('positions')
                    ->label('# of positions')
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
                            ->url(fn (Model $record) => route('departments.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Model $record) => route('departments.edit', $record)),
                    ])->authorizeAny(['view', 'update'])->divided(),
                    ActionGroup::make([
                        ReplicateAction::make()
                            ->form([
                                TextInput::make('name')->label('New department name'),
                            ])
                            ->modalHeading('Duplicate department?')
                            ->modalSubheading(
                                fn (Model $record) => "Are you sure you want to duplicate the {$record->name} department and all of its positions?"
                            )
                            ->modalSubmitActionLabel('Duplicate')
                            ->action(function (Model $record, array $data) {
                                $replica = DuplicateDepartmentManager::run(
                                    $record,
                                    array_merge($record->toArray(), $data)
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
                            ->close()
                            ->modalHeading('Delete department?')
                            ->modalSubheading(
                                fn (Model $record) => "Are you sure you want to delete the {$record->name} department? You won't be able to recover it. All positions assigned to this department will be removed. As a result, any characters assigned to a position that is removed will need to be re-assigned to another position."
                            )
                            ->modalSubmitActionLabel('Delete')
                            ->successNotificationTitle('Department was deleted')
                            ->using(fn (Model $record) => DeleteDepartment::run($record)),
                    ])->authorize('delete')->divided(),
                ]),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->authorize('deleteAny')
                    ->modalHeading(
                        fn (Collection $records) => "Delete {$records->count()} selected ".str('department')->plural($records->count()).'?'
                    )
                    ->modalSubheading(function (Collection $records) {
                        $statement = ($records->count() === 1)
                            ? 'this 1 department'
                            : "these {$records->count()} departments";

                        $notice = ($records->count() === 1) ? 'it' : 'them';

                        return "Are you sure you want to delete {$statement}? You won't be able to recover {$notice}. Any positions assigned to {$statement} will also be deleted. As a result, any characters assigned to a position that is removed will need to be re-assigned to another position.";
                    })
                    ->modalSubmitActionLabel('Delete')
                    ->successNotificationTitle('Departments were deleted')
                    ->using(fn (Collection $records) => $records->each(
                        fn (Model $record) => DeleteDepartment::run($record)
                    )),
            ])
            ->filters([
                TernaryFilter::make('has_positions')
                    ->queries(
                        true: fn (Builder $query) => $query->whereHas('positions'),
                        false: fn (Builder $query) => $query->whereDoesntHave('positions')
                    ),
                SelectFilter::make('status')->options(DepartmentStatus::class),
            ])
            ->heading('Departments')
            ->description("Organize character positions into logical groups that you can display on your manifests")
            ->headerActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add')
                    ->url(route('departments.create')),
            ])
            ->header(fn () => $this->isTableReordering() ? view('filament.tables.reordering-notice') : null)
            ->reorderable('order_column')
            ->emptyStateIcon(iconName('list'))
            ->emptyStateHeading('No departments found')
            ->emptyStateDescription("Departments allow you to organize character positions into logical groups that you can display on your manifests.")
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add a department')
                    ->url(route('departments.create')),
            ]);
    }

    public function render()
    {
        return view('livewire.filament-table');
    }
}
