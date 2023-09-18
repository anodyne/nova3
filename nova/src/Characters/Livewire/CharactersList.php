<?php

declare(strict_types=1);

namespace Nova\Characters\Livewire;

use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Nova\Characters\Actions\ActivateCharacter;
use Nova\Characters\Actions\DeactivateCharacter;
use Nova\Characters\Actions\DeleteCharacter;
use Nova\Characters\Actions\RestoreCharacter;
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Events\CharacterActivated;
use Nova\Characters\Events\CharacterDeactivated;
use Nova\Characters\Events\CharacterDeletedByAdmin;
use Nova\Characters\Events\CharacterRestored;
use Nova\Characters\Models\Character;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\RestoreAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Foundation\Livewire\TableComponent;

class CharactersList extends TableComponent
{
    protected $queryString = [
        'tableFilters',
    ];

    // public ?array $tableFilters = [
    //     'only_my_characters',
    // ];

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Character::with('media', 'positions', 'rank.name', 'users', 'activeUsers')
                    ->withTrashed()
                    ->unless(
                        auth()->user()->can('manage', new Character()),
                        fn ($query): Builder => $query->isAssignedTo(auth()->user())
                    )
            )
            ->groups([
                Group::make('status')->collapsible(),
                Group::make('type')->collapsible(),
            ])
            ->columns([
                ViewColumn::make('name')
                    ->view('filament.tables.columns.character-avatar')
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query->searchFor($search)),
                TextColumn::make('activeUsers.name')
                    ->visible(auth()->user()->can('viewAny', Character::class))
                    ->label('Played by')
                    ->listWithLineBreaks()
                    ->toggleable(),
                TextColumn::make('type')
                    ->badge()
                    ->color(fn (Model $record) => $record->type->color())
                    ->toggleable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (Model $record) => $record->status->color())
                    ->formatStateUsing(fn (Model $record) => $record->status->getLabel())
                    ->toggleable(),
            ])
            ->actions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make()
                            ->authorize('view')
                            ->url(fn (Model $record) => route('characters.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Model $record) => route('characters.edit', $record)),
                    ])->authorizeAny(['view', 'update'])->divided(),
                    ActionGroup::make([
                        Action::make('activate')
                            ->authorize('activate')
                            ->requiresConfirmation()
                            ->icon(iconName('check'))
                            ->color('gray')
                            ->modalHeading('Activate character?')
                            ->modalDescription(fn (Model $record): string => "Are you sure you want to activate {$record->name}?")
                            ->modalIcon(iconName('check'))
                            ->modalIconColor('primary')
                            ->modalSubmitActionLabel('Activate')
                            ->modalWidth('lg')
                            ->action(function (Model $record): void {
                                $character = ActivateCharacter::run($record);

                                CharacterActivated::dispatch($character);

                                Notification::make()->success()
                                    ->title($record->name.' has been activated')
                                    ->send();
                            }),
                        Action::make('deactivate')
                            ->authorize('deactivate')
                            ->requiresConfirmation()
                            ->icon(iconName('remove'))
                            ->color('gray')
                            ->modalHeading('Deactivate character?')
                            ->modalDescription(fn (Model $record): string => "Are you sure you want to deactivate {$record->name}?")
                            ->modalIcon(iconName('warning'))
                            ->modalIconColor('primary')
                            ->modalSubmitActionLabel('Deactivate')
                            ->modalWidth('lg')
                            ->action(function (Model $record): void {
                                $character = DeactivateCharacter::run($record);

                                CharacterDeactivated::dispatch($character);

                                Notification::make()->success()
                                    ->title($record->name.' has been deactivated')
                                    ->send();
                            }),
                    ])->authorizeAny(['activate', 'deactivate'])->divided(),
                    ActionGroup::make([
                        DeleteAction::make()
                            ->authorize('delete')
                            ->modalHeading('Delete character?')
                            ->modalDescription('Are you sure you want to delete this character?')
                            ->modalSubmitActionLabel('Delete')
                            ->using(function (Model $record): void {
                                $character = DeleteCharacter::run($record);

                                CharacterDeletedByAdmin::dispatch($character);

                                Notification::make()->success()
                                    ->title($record->name.' was deleted')
                                    ->send();
                            }),
                        RestoreAction::make()
                            ->authorize('restore')
                            ->modalHeading('Restore character?')
                            ->modalDescription(fn (Model $record): string => "Are you sure you want to restore {$record->name}?")
                            ->modalSubmitActionLabel('Restore')
                            ->action(function (Model $record): void {
                                $character = RestoreCharacter::run($record);

                                CharacterRestored::dispatch($character);

                                Notification::make()->success()
                                    ->title($record->name.' was restored')
                                    ->send();
                            }),
                    ])->authorizeAny(['delete', 'forceDelete', 'restore'])->divided(),
                ]),
            ])
            ->groupedBulkActions([
                BulkAction::make('bulk_activate')
                    ->requiresConfirmation()
                    ->icon(iconName('check'))
                    ->color('gray')
                    ->label('Activate selected')
                    ->successNotificationTitle('Characters were activated')
                    ->action(
                        fn (Collection $records) => $records->each(function (Model $record) {
                            $character = ActivateCharacter::run($record);

                            CharacterActivated::dispatch($character);
                        })
                    ),
                BulkAction::make('bulk_deactivate')
                    ->requiresConfirmation()
                    ->icon(iconName('remove'))
                    ->color('gray')
                    ->label('Deactivate selected')
                    ->successNotificationTitle('Characters were deactivated')
                    ->action(
                        fn (Collection $records) => $records->each(function (Model $record) {
                            $character = DeactivateCharacter::run($record);

                            CharacterDeactivated::dispatch($character);
                        })
                    ),
                DeleteBulkAction::make()
                    ->authorize('deleteAny')
                    ->modalHeading(
                        fn (Collection $records) => "Delete {$records->count()} selected ".str('character')->plural($records->count()).'?'
                    )
                    ->modalDescription(function (Collection $records) {
                        $statement = ($records->count() === 1)
                            ? 'this character'
                            : "these {$records->count()} characters";

                        return "Are you sure you want to delete {$statement}?";
                    })
                    ->modalSubmitActionLabel('Delete')
                    ->action(function (Collection $records) {
                        foreach ($records as $record) {
                            /** @var Model $record */
                            $character = DeleteCharacter::run($record);

                            CharacterDeletedByAdmin::dispatch($character);
                        }

                        Notification::make()->success()
                            ->title($records->count().' '.str('character')->plural($records->count()).' were deleted')
                            ->send();
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->multiple()
                    ->options(fn () => Character::getStatesFor('status')->flatMap(fn ($state) => [$state => ucfirst($state)])->all()),
                SelectFilter::make('type')
                    ->multiple()
                    ->options(CharacterType::class),
                Filter::make('only_my_characters')
                    ->toggle()
                    ->query(fn (Builder $query) => $query->whereRelation('users', 'users.id', '=', auth()->id()))
                    ->visible(auth()->user()->can('manage', new Character())),
                TrashedFilter::make()->label('Deleted characters'),
            ])
            ->heading('Characters')
            ->description("Manage all of the game's characters")
            ->headerActions([
                CreateAction::make()
                    ->authorize('createAny')
                    ->label('Add')
                    ->url(route('characters.create')),
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
}
