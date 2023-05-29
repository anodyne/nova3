<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Kirschbaum\LivewireFilters\Filter;
use Kirschbaum\LivewireFilters\HasFilters;
use Livewire\Component;
use Livewire\WithPagination;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Users\Actions\DeleteUser;
use Nova\Users\Models\User;

class UsersList extends Component implements HasTable
{
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(User::with('media', 'latestLogin'))
            ->columns([
                ViewColumn::make('name')
                    ->view('filament.tables.columns.user-avatar')
                    ->searchable(query: fn (Builder $query, string $search) => $query->searchFor($search)),
                TextColumn::make('updated_at')
                    ->label('Last activity')
                    ->since()
                    ->toggleable(),
                TextColumn::make('latestLogin.created_at')
                    ->label('Last sign in')
                    ->since()
                    ->toggleable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (Model $record) => $record->status->color())
                    ->formatStateUsing(fn (Model $record) => $record->status->displayName()),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make()->url(fn (Model $record) => route('users.show', $record)),
                    EditAction::make()->url(fn (Model $record) => route('users.edit', $record)),
                    DeleteAction::make()
                        ->modalHeading('Delete user?')
                        ->modalSubheading("Are you sure you want to delete this user? You won't be able to recover it.")
                        ->modalSubmitActionLabel('Delete')
                        ->using(fn (Model $record) => DeleteUser::run($record)),
                ]),
            ])
            ->bulkActions([
                DeleteBulkAction::make()
                    ->action(
                        fn (Collection $records) => $records->each(
                            fn (Model $record) => DeleteUser::run($record)
                        )
                    ),
            ])
            ->checkIfRecordIsSelectableUsing(fn (Model $record): bool => $record->id !== auth()->id())
            ->filters([
                SelectFilter::make('status')->options(fn () => User::getStatesFor('status')),
                TernaryFilter::make('assigned_characters')
                    ->label('Has assigned characters')
                    ->queries(
                        true: fn (Builder $query) => $query->whereHas('activeCharacters'),
                        false: fn (Builder $query) => $query->whereDoesntHave('activeCharacters')
                    ),
            ])
            ->heading('Users')
            ->description("Manage all of the game's users")
            ->headerActions([
                CreateAction::make()
                    ->label('Add')
                    ->url(route('users.create')),
            ])
            ->emptyStateIcon(iconName('users'))
            ->emptyStateHeading('No users found')
            ->emptyStateActions([
                CreateAction::make()
                    ->label('Add a user')
                    ->url(route('users.create')),
            ]);
    }

    public function render()
    {
        return view('livewire.filament-table');
    }

    // use HasFilters;
    // use WithPagination;

    // public $search;

    // public function filters(): array
    // {
    //     $statusFilter = Filter::make('status')
    //         ->options(
    //             User::getStatesFor('status')
    //                 ->flatMap(fn ($status) => [$status => ucfirst($status)])
    //                 ->all()
    //         )
    //         ->default(['active'])
    //         ->meta(['label' => 'Status']);

    //     $assignedCharactersFilter = Filter::make('assigned_characters')
    //         ->options(['yes' => 'Yes', 'no' => 'No'])
    //         ->meta(['label' => 'Has assigned character(s)']);

    //     return [
    //         $statusFilter,
    //         $assignedCharactersFilter,
    //     ];
    // }

    // public function clearAll()
    // {
    //     $this->reset('search');

    //     $this->emit('livewire-filters-reset');

    //     $this->dispatchBrowserEvent('close-filters-panel');
    // }

    // public function getFilteredUsersProperty()
    // {
    //     return User::with('media', 'latestLogin')
    //         ->when($this->getFilterValue('status'), fn ($query, $values) => $query->whereIn('status', $values))
    //         ->when($this->getFilterValue('assigned_characters') === 'yes', fn ($query) => $query->whereHas('characters'))
    //         ->when($this->getFilterValue('assigned_characters') === 'no', fn ($query) => $query->doesntHave('characters'))
    //         ->when($this->search, fn ($query, $value) => $query->searchFor($value))
    //         ->orderBy('name')
    //         ->paginate();
    // }

    // public function render()
    // {
    //     return view('livewire.users.users-list', [
    //         'activeFilterCount' => $this->activeFilterCount,
    //         'isFiltered' => $this->isFiltered,
    //         'userClass' => User::class,
    //         'userCount' => User::count(),
    //         'users' => $this->filteredUsers,
    //     ]);
    // }
}
