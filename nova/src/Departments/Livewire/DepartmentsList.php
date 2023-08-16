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
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Livewire\Component;
use Nova\Departments\Actions\DeleteDepartment;
use Nova\Departments\Actions\DuplicateDepartment;
use Nova\Departments\Data\DepartmentData;
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
                            ->url(fn (Model $record): string => route('departments.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Model $record): string => route('departments.edit', $record)),
                    ])->authorizeAny(['view', 'update'])->divided(),
                    ActionGroup::make([
                        ReplicateAction::make()
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
                            ->modalContentView('pages.departments.delete')
                            ->successNotificationTitle('Department was deleted')
                            ->using(fn (Model $record): Model => DeleteDepartment::run($record)),
                    ])->authorize('delete')->divided(),
                ]),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->authorize('deleteAny')
                    ->modalContentView('pages.departments.delete-bulk')
                    ->successNotificationTitle('Departments were deleted')
                    ->using(fn (Collection $records): Collection => $records->each(
                        fn (Model $record): Model => DeleteDepartment::run($record)
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
            ->description('Organize character positions into logical groups that you can display on your manifests')
            ->headerActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add')
                    ->url(route('departments.create')),
            ])
            ->header(fn (): ?View => $this->isTableReordering() ? view('filament.tables.reordering-notice') : null)
            ->reorderable('order_column')
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

    public function render()
    {
        return view('livewire.filament-table');
    }
}
