<?php

declare(strict_types=1);

namespace Nova\Characters\Livewire;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Livewire\Component;
use Nova\Characters\Actions\ActivateCharacter;
use Nova\Characters\Actions\DeactivateCharacter;
use Nova\Characters\Actions\DeleteCharacter;
use Nova\Characters\Models\Character;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;

class CharactersList extends Component implements HasForms, HasTable
{
    // use HasFilters;
    // use WithPagination;

    // public $search;

    // public function filters(): array
    // {
    //     $statusFilter = Filter::make('status')
    //         ->options(
    //             Character::getStatesFor('status')
    //                 ->flatMap(fn ($status) => [$status => ucfirst($status)])
    //                 ->all()
    //         )
    //         ->default(['active'])
    //         ->meta(['label' => 'Status']);

    //     $typeFilter = Filter::make('type')
    //         ->options(
    //             Character::getStatesFor('type')
    //                 ->flatMap(fn ($type) => [$type => ucfirst($type)])
    //                 ->all()
    //         )
    //         ->default(['primary', 'secondary', 'support'])
    //         ->meta(['label' => 'Type']);

    //     $assignedUsersFilter = Filter::make('assigned_users')
    //         ->options(['yes' => 'Yes', 'no' => 'No'])
    //         ->meta(['label' => 'Has assigned user(s)']);

    //     $assignedPositionsFilter = Filter::make('assigned_positions')
    //         ->options(['yes' => 'Yes', 'no' => 'No'])
    //         ->meta(['label' => 'Has assigned position(s)']);

    //     $myCharactersFilter = Filter::make('my_characters')
    //         ->options(['yes' => 'Yes'])
    //         ->meta(['label' => 'Only show my character(s)']);

    //     return [
    //         $typeFilter,
    //         $statusFilter,
    //         $assignedUsersFilter,
    //         $assignedPositionsFilter,
    //         $myCharactersFilter,
    //     ];
    // }

    // public function clearAll()
    // {
    //     $this->reset('search');

    //     $this->emit('livewire-filters-reset');

    //     $this->dispatchBrowserEvent('close-filters-panel');
    // }

    // public function getFilteredCharactersProperty()
    // {
    //     return Character::with('media', 'positions', 'rank.name', 'users')
    //         ->when(
    //             auth()->user()->cannot('viewAny', Character::class),
    //             fn ($query) => $query->whereRelation('users', 'users.id', '=', auth()->id())
    //         )
    //         ->when(
    //             $this->getFilterValue('my_characters') === 'yes',
    //             fn ($query) => $query->whereRelation('users', 'users.id', '=', auth()->id())
    //         )
    //         ->when($this->getFilterValue('status'), fn ($query, $values) => $query->whereIn('status', $values))
    //         ->when($this->getFilterValue('type'), fn ($query, $values) => $query->whereIn('type', $values))
    //         ->when($this->getFilterValue('assigned_users') === 'yes', fn ($query) => $query->whereHas('users'))
    //         ->when($this->getFilterValue('assigned_users') === 'no', fn ($query) => $query->doesntHave('users'))
    //         ->when($this->getFilterValue('assigned_positions') === 'yes', fn ($query) => $query->whereHas('positions'))
    //         ->when($this->getFilterValue('assigned_positions') === 'no', fn ($query) => $query->doesntHave('positions'))
    //         ->when($this->search, fn ($query, $value) => $query->searchFor($value))
    //         ->orderBy('name')
    //         ->paginate();
    // }

    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Character::with('media', 'positions', 'rank.name', 'users')
                    ->when(
                        auth()->user()->cannot('viewAny', Character::class),
                        fn ($query) => $query->whereRelation('users', 'users.id', '=', auth()->id())
                    )
            )
            ->columns([
                ViewColumn::make('name')
                    ->view('filament.tables.columns.character-avatar')
                    ->searchable(query: fn (Builder $query, string $search) => $query->searchFor($search)),
                TextColumn::make('activeUsers.name')
                    ->visible(auth()->user()->can('viewAny', Character::class))
                    ->label('Played by')
                    ->listWithLineBreaks()
                    ->toggleable(),
                TextColumn::make('type')
                    ->badge()
                    ->color(fn (Model $record) => $record->type->color())
                    ->formatStateUsing(fn (Model $record) => $record->type->getLabel())
                    ->toggleable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (Model $record) => $record->status->color())
                    ->formatStateUsing(fn (Model $record) => $record->status->getLabel())
                    ->toggleable(),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make()
                        ->authorize('view')
                        ->url(fn (Model $record) => route('characters.show', $record)),
                    EditAction::make()
                        ->authorize('update')
                        ->url(fn (Model $record) => route('characters.edit', $record)),
                    Action::make('activate')
                        ->authorize('activate')
                        ->icon(iconName('check'))
                        ->color('gray')
                        ->requiresConfirmation(),
                    Action::make('deactivate')
                        ->authorize('deactivate')
                        ->icon(iconName('remove'))
                        ->color('gray')
                        ->requiresConfirmation(),
                    DeleteAction::make()
                        ->authorize('delete')
                        ->modalHeading('Delete character?')
                        ->modalSubheading("Are you sure you want to delete this character? You won't be able to recover it.")
                        ->modalSubmitActionLabel('Delete')
                        ->using(fn (Model $record) => DeleteCharacter::run($record)),
                ]),
            ])
            ->groupedBulkActions([
                BulkAction::make('bulk_activate')
                    ->icon(iconName('check'))
                    ->color('gray')
                    ->label('Activate selected')
                    ->requiresConfirmation()
                    ->action(
                        fn (Collection $records) => $records->each(
                            fn (Model $record) => ActivateCharacter::run($record)
                        )
                    ),
                BulkAction::make('bulk_deactivate')
                    ->icon(iconName('remove'))
                    ->color('gray')
                    ->label('Deactivate selected')
                    ->requiresConfirmation()
                    ->action(
                        fn (Collection $records) => $records->each(
                            fn (Model $record) => DeactivateCharacter::run($record)
                        )
                    ),
                DeleteBulkAction::make()
                    ->requiresConfirmation()
                    ->action(
                        fn (Collection $records) => $records->each(
                            fn (Model $record) => DeleteCharacter::run($record)
                        )
                    ),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->multiple()
                    ->options(fn () => Character::getStatesFor('status')),
                SelectFilter::make('type')
                    ->multiple()
                    ->options(fn () => Character::getStatesFor('type')),
                Filter::make('only_my_characters')
                    ->toggle()
                    ->query(fn (Builder $query) => $query->whereRelation('users', 'users.id', '=', auth()->id())),
                TrashedFilter::make()->label('Deleted characters'),
            ])
            ->groups([
                Group::make('status')->collapsible(),
                Group::make('type')->collapsible(),
            ])
            ->heading('Characters')
            ->description("Manage all of the game's characters")
            ->headerActions([
                CreateAction::make()
                    ->label('Add')
                    ->url(route('characters.create'))
                    ->authorize('createAny'),
            ])
            ->emptyStateIcon(iconName('characters'))
            ->emptyStateHeading('No characters found')
            ->emptyStateDescription('Departments allow you to organize character positions into logical groups that you can display on your manifests.')
            ->emptyStateActions([
                CreateAction::make()
                    ->label('Add a character')
                    ->url(route('characters.create'))
                    ->authorize('createAny'),
            ]);
    }

    public function render()
    {
        return view('livewire.filament-table');
    }
}
