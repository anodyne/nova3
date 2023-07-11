<?php

declare(strict_types=1);

namespace Nova\Roles\Livewire;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Livewire\Component;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ReplicateAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Roles\Actions\DeleteRole;
use Nova\Roles\Actions\DuplicateRole;
use Nova\Roles\Events\RoleDuplicated;
use Nova\Roles\Models\Role;

class RolesList extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Role::withCount([
                    'user as active_users_count' => fn (Builder $query): Builder => $query->active(),
                    'user as inactive_users_count' => fn (Builder $query): Builder => $query->inactive(),
                ])
            )
            ->columns([
                TextColumn::make('display_name')
                    ->titleColumn()
                    ->label('Name')
                    ->icon(fn (Model $record): ?string => $record->locked ? iconName('lock-closed') : null)
                    ->iconPosition('after')
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query->searchFor($search)),
                TextColumn::make('active_users_count')
                    ->label('# of active users')
                    ->alignCenter()
                    ->toggleable(),
                TextColumn::make('inactive_users_count')
                    ->label('# of inactive users')
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('permissions_count')
                    ->counts('permissions')
                    ->label('# of permissions')
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('default')
                    ->label('Assigned to new users')
                    ->alignCenter()
                    ->icons([
                        iconName('check') => fn ($state): bool => $state === true,
                    ])
                    ->color('success'),
            ])
            ->actions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make()
                            ->authorize('view')
                            ->url(fn (Model $record): string => route('roles.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Model $record): string => route('roles.edit', $record)),
                    ])->authorizeAny(['view', 'update'])->divided(),
                    ActionGroup::make([
                        ReplicateAction::make()
                            ->modalHeading('Duplicate role?')
                            ->modalDescription(
                                fn (Model $record): string => "Are you sure you want to duplicate the {$record->name} role?"
                            )
                            ->modalSubmitActionLabel('Duplicate')
                            ->action(function (Model $record): void {
                                $replica = DuplicateRole::run($record);

                                dispatch(new RoleDuplicated($replica, $record));

                                Notification::make()->success()
                                    ->title("{$record->name} role has been duplicated")
                                    ->send();
                            }),
                    ])->authorize('duplicate')->divided(),
                    ActionGroup::make([
                        DeleteAction::make()
                            ->close()
                            ->modalHeading('Delete role?')
                            ->modalDescription(
                                fn (Model $record): string => "Are you sure you want to delete the {$record->name} role? You won't be able to recover it. Any user assigned this role will lose access to what this role provides."
                            )
                            ->modalSubmitActionLabel('Delete')
                            ->successNotificationTitle('Role was deleted')
                            ->using(fn (Model $record): Model => DeleteRole::run($record)),
                    ])->authorize('delete')->divided(),
                ]),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->authorize('deleteAny')
                    ->modalHeading(
                        fn (Collection $records): string => "Delete {$records->count()} selected ".str('role')->plural($records->count()).'?'
                    )
                    ->modalDescription(function (Collection $records): string {
                        $statement = ($records->count() === 1)
                            ? 'this 1 role'
                            : "these {$records->count()} roles";

                        $notice = ($records->count() === 1) ? 'it' : 'them';

                        return "Are you sure you want to delete {$statement}? You won't be able to recover {$notice}. Any user assigned to {$statement} will lose access to what permissions {$statement} provides.";
                    })
                    ->modalSubmitActionLabel('Delete')
                    ->successNotificationTitle('Roles were deleted')
                    ->using(fn (Collection $records): Collection => $records->each(
                        fn (Model $record): Model => DeleteRole::run($record)
                    )),
            ])
            ->filters([
                TernaryFilter::make('default')
                    ->label('Assigned to new users')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->where('default', true),
                        false: fn (Builder $query): Builder => $query->where('default', false),
                    ),
                TernaryFilter::make('has_permissions')
                    ->label('Has assigned permissions')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->whereHas('permissions'),
                        false: fn (Builder $query): Builder => $query->whereDoesntHave('permissions'),
                    ),
                TernaryFilter::make('has_users')
                    ->label('Has assigned users')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->whereHas('user'),
                        false: fn (Builder $query): Builder => $query->whereDoesntHave('user'),
                    ),
            ])
            ->reorderable('order_column')
            ->heading('Roles')
            ->description('Control what users can do throughout Nova')
            ->headerActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add')
                    ->url(route('roles.create')),
            ])
            ->header(fn () => $this->isTableReordering() ? view('filament.tables.roles-reordering-notice') : null)
            ->emptyStateIcon(iconName('key'))
            ->emptyStateHeading('No roles found')
            ->emptyStateDescription('Roles allow you to control what users can and cannot access throughout Nova.')
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add a role')
                    ->url(route('roles.create')),
            ]);
    }

    public function render()
    {
        return view('livewire.filament-table');
    }
}
