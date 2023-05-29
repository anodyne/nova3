<?php

declare(strict_types=1);

namespace Nova\Roles\Livewire;

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
use Nova\Roles\Models\Role;

class RolesList extends Component implements HasTable
{
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Role::withCount([
                    'user as active_users_count' => fn ($query) => $query->whereActive(),
                    'user as inactive_users_count' => fn ($query) => $query->whereInactive(),
                ])
            )
            ->columns([
                TextColumn::make('display_name')
                    ->titleColumn()
                    ->label('Name')
                    ->icon(fn (Model $record) => $record->locked ? iconName('lock-closed') : null)
                    ->iconPosition('after')
                    ->searchable(query: fn (Builder $query, string $search) => $query->searchFor($search)),
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
                    ViewAction::make()
                        ->url(fn (Model $record) => route('departments.show', $record))
                        ->authorize('view'),
                    EditAction::make()
                        ->url(fn (Model $record) => route('departments.edit', $record))
                        ->authorize('update'),
                    ReplicateAction::make(),
                    DeleteAction::make()
                        ->authorize('delete')
                        ->modalHeading('Delete department?')
                        ->modalSubheading("Are you sure you want to delete this department? You won't be able to recover it.")
                        ->modalSubmitActionLabel('Delete')
                        ->using(fn (Model $record) => DeleteRole::run($record)),
                ]),
            ])
            ->bulkActions([
                DeleteBulkAction::make()
                    ->requiresConfirmation()
                    ->action(
                        fn (Collection $records) => $records->each(
                            fn (Model $record) => DeleteRole::run($record)
                        )
                    ),
            ])
            ->checkIfRecordIsSelectableUsing(fn (Model $record): bool => $record->locked !== true)
            ->filters([
                TernaryFilter::make('default')
                    ->label('Assigned to new users')
                    ->queries(
                        true: fn (Builder $query) => $query->where('default', true),
                        false: fn (Builder $query) => $query->where('default', false),
                    ),
                TernaryFilter::make('has_permissions')
                    ->label('Has assigned permissions')
                    ->queries(
                        true: fn (Builder $query) => $query->whereHas('permissions'),
                        false: fn (Builder $query) => $query->whereDoesntHave('permissions'),
                    ),
                TernaryFilter::make('has_users')
                    ->label('Has assigned users')
                    ->queries(
                        true: fn (Builder $query) => $query->whereHas('user'),
                        false: fn (Builder $query) => $query->whereDoesntHave('user'),
                    ),
            ])
            ->reorderable('order_column')
            ->heading('Roles')
            ->description("Control what users can do throughout Nova")
            ->headerActions([
                CreateAction::make()->label('Add')->url(route('roles.create')),
            ])
            ->header(fn () => $this->isTableReordering() ? view('filament.tables.roles-reordering-notice') : null)
            ->emptyStateIcon(iconName('list'))
            ->emptyStateHeading('No departments found')
            ->emptyStateDescription("Departments allow you to organize character positions into logical groups that you can display on your manifests.")
            ->emptyStateActions([
                CreateAction::make()
                    ->label('Add a department')
                    ->url(route('departments.create')),
            ]);
    }

    public function render()
    {
        return view('livewire.filament-table');
    }

    // use AuthorizesRequests;
    // use CanReorder;
    // use HasFilters;
    // use WithPagination;

    // public $search;

    // public function filters(): array
    // {
    //     $defaultRoles = Filter::make('default_roles')
    //         ->options(['yes' => 'Yes', 'no' => 'No'])
    //         ->meta(['label' => 'Assigned to new user(s)']);

    //     $hasPermissions = Filter::make('has_permissions')
    //         ->options(['yes' => 'Yes', 'no' => 'No'])
    //         ->meta(['label' => 'Has assigned permissions']);

    //     $hasUsers = Filter::make('has_users')
    //         ->options(['yes' => 'Yes', 'no' => 'No'])
    //         ->meta(['label' => 'Has assigned users']);

    //     return [
    //         $defaultRoles,
    //         $hasPermissions,
    //         $hasUsers,
    //     ];
    // }

    // public function clearAll()
    // {
    //     $this->reset('search');

    //     $this->emit('livewire-filters-reset');

    //     $this->dispatchBrowserEvent('close-filters-panel');
    // }

    // public function getFilteredRolesProperty()
    // {
    //     $roles = Role::query()
    //         ->withCount([
    //             'user as active_users_count' => fn ($query) => $query->whereActive(),
    //             'user as inactive_users_count' => fn ($query) => $query->whereInactive(),
    //         ])
    //         ->with(['user' => fn ($query) => $query->whereActive()->limit(4)])
    //         ->when($this->getFilterValue('default_roles') === 'yes', fn ($query) => $query->where('default', true))
    //         ->when($this->getFilterValue('default_roles') === 'no', fn ($query) => $query->where('default', false))
    //         ->when($this->getFilterValue('has_permissions') === 'yes', fn ($query) => $query->whereHas('permissions'))
    //         ->when($this->getFilterValue('has_permissions') === 'no', fn ($query) => $query->whereDoesntHave('permissions'))
    //         ->when($this->getFilterValue('has_users') === 'yes', fn ($query) => $query->whereHas('user'))
    //         ->when($this->getFilterValue('has_users') === 'no', fn ($query) => $query->whereDoesntHave('user'))
    //         ->when($this->search, fn ($query, $value) => $query->searchFor($value))
    //         ->orderBySort();

    //     if ($this->reordering) {
    //         return $roles->get();
    //     }

    //     return $roles->paginate();
    // }

    // public function reorder(array $items): void
    // {
    //     $this->authorize('update', new Role());

    //     ReorderRoles::run($items);
    // }

    // public function render()
    // {
    //     return view('livewire.roles.roles-list', [
    //         'activeFilterCount' => $this->activeFilterCount,
    //         'isFiltered' => $this->isFiltered,
    //         'roleClass' => Role::class,
    //         'roleCount' => Role::count(),
    //         'roles' => $this->filteredRoles,
    //     ]);
    // }
}
