<?php

declare(strict_types=1);

namespace Nova\Characters\Livewire;

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
use Livewire\Attributes\Url;
use Nova\Characters\Actions\ActivateCharacter;
use Nova\Characters\Actions\DeactivateCharacter;
use Nova\Characters\Actions\DeleteCharacter;
use Nova\Characters\Actions\ForceDeleteCharacter;
use Nova\Characters\Actions\RestoreCharacter;
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Events\CharacterActivated;
use Nova\Characters\Events\CharacterDeactivated;
use Nova\Characters\Events\CharacterDeletedByAdmin;
use Nova\Characters\Events\CharacterForceDeleted;
use Nova\Characters\Events\CharacterRestored;
use Nova\Characters\Models\Character;
use Nova\Foundation\Filament\Actions\Action;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\BulkAction;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ForceDeleteAction;
use Nova\Foundation\Filament\Actions\RestoreAction;
use Nova\Foundation\Filament\Actions\RestoreBulkAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Livewire\TableComponent;

class CharactersList extends TableComponent
{
    #[Url]
    public ?array $tableFilters = [
        'only_my_characters',
    ];

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Character::with('media', 'positions', 'rank.name', 'users', 'activeUsers')
                    ->withTrashed()
                    ->unless(
                        auth()->user()->can('manage', new Character()),
                        fn (Builder $query): Builder => $query->isAssignedTo(auth()->user())
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
                    ->color(fn (Model $record): string => $record->type->color())
                    ->toggleable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (Model $record): string => $record->trashed() ? 'danger' : $record->status->color())
                    ->formatStateUsing(fn (Model $record): string => $record->trashed() ? 'Deleted' : $record->status->getLabel())
                    ->toggleable(),
            ])
            ->actions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make()
                            ->authorize('view')
                            ->url(fn (Model $record): string => route('characters.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Model $record): string => route('characters.edit', $record)),
                    ])->authorizeAny(['view', 'update'])->divided(),

                    ActionGroup::make([
                        Action::make('activate')
                            ->authorize('activate')
                            ->icon(iconName('check'))
                            ->color('gray')
                            ->modalContentView('pages.characters.activate')
                            ->modalSubmitActionLabel('Activate')
                            ->action(function (Model $record): void {
                                $character = ActivateCharacter::run($record);

                                CharacterActivated::dispatch($character);

                                Notification::make()->success()
                                    ->title($record->name.' has been activated')
                                    ->send();
                            }),
                        Action::make('deactivate')
                            ->authorize('deactivate')
                            ->icon(iconName('remove'))
                            ->color('gray')
                            ->modalContentView('pages.characters.deactivate')
                            ->modalSubmitActionLabel('Deactivate')
                            ->action(function (Model $record): void {
                                $character = DeactivateCharacter::run($record);

                                CharacterDeactivated::dispatch($character);

                                Notification::make()->success()
                                    ->title($record->name.' has been deactivated')
                                    ->send();
                            }),
                    ])->authorizeAny(['activate', 'deactivate'])->divided(),

                    ActionGroup::make([
                        RestoreAction::make()
                            ->authorize('restore')
                            ->modalContentView('pages.characters.restore')
                            ->action(function (Model $record): void {
                                $character = RestoreCharacter::run($record);

                                CharacterRestored::dispatch($character);

                                Notification::make()->success()
                                    ->title($record->name.' was restored')
                                    ->send();
                            }),
                        DeleteAction::make()
                            ->authorize('delete')
                            ->modalContentView('pages.characters.delete')
                            ->using(function (Model $record): void {
                                $character = DeleteCharacter::run($record);

                                CharacterDeletedByAdmin::dispatch($character);

                                Notification::make()->success()
                                    ->title($record->name.' was deleted')
                                    ->send();
                            }),
                        ForceDeleteAction::make()
                            ->authorize('forceDelete')
                            ->modalContentView('pages.characters.force-delete')
                            ->using(function (Model $record): void {
                                $character = ForceDeleteCharacter::run($record);

                                CharacterForceDeleted::dispatch($character);

                                Notification::make()->success()
                                    ->title($record->name.' was force deleted')
                                    ->send();
                            }),
                    ])->authorizeAny(['delete', 'forceDelete', 'restore'])->divided(),
                ]),
            ])
            ->groupedBulkActions([
                BulkAction::make('bulk_activate')
                    ->icon(iconName('check'))
                    ->color('gray')
                    ->label('Activate selected')
                    ->modalContentView('pages.characters.activate-bulk')
                    ->modalSubmitActionLabel('Activate')
                    ->deselectRecordsAfterCompletion()
                    ->action(function (Collection $records): void {
                        $records->each(function (Model $record): void {
                            $character = ActivateCharacter::run($record);

                            CharacterActivated::dispatch($character);
                        });

                        Notification::make()->success()
                            ->title(str('character')->plural(count($records))->prepend(count($records).' ').' were activated')
                            ->send();
                    }),
                BulkAction::make('bulk_deactivate')
                    ->icon(iconName('remove'))
                    ->color('gray')
                    ->label('Deactivate selected')
                    ->modalContentView('pages.characters.deactivate-bulk')
                    ->modalSubmitActionLabel('Deactivate')
                    ->deselectRecordsAfterCompletion()
                    ->action(function (Collection $records): void {
                        $records->each(function (Model $record): void {
                            $character = DeactivateCharacter::run($record);

                            CharacterDeactivated::dispatch($character);
                        });

                        Notification::make()->success()
                            ->title(str('character')->plural(count($records))->prepend(count($records).' ').' were deactivated')
                            ->send();
                    }),
                RestoreBulkAction::make()
                    ->authorize('restoreAny')
                    ->modalContentView('pages.characters.restore-bulk')
                    ->action(function (Collection $records) {
                        foreach ($records as $record) {
                            /** @var Model $record */
                            $character = RestoreCharacter::run($record);

                            CharacterRestored::dispatch($character);
                        }

                        Notification::make()->success()
                            ->title($records->count().' '.str('character')->plural($records->count()).' were restored')
                            ->send();
                    }),
                DeleteBulkAction::make()
                    ->authorize('deleteAny')
                    ->modalContentView('pages.characters.delete-bulk')
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
                    ->options(fn (): array => Character::getStatesFor('status')->flatMap(fn ($state) => [$state => ucfirst($state)])->all()),
                SelectFilter::make('type')
                    ->multiple()
                    ->options(CharacterType::class),
                Filter::make('only_my_characters')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->whereRelation('users', 'users.id', '=', auth()->id()))
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
            ->emptyStateDescription('')
            ->emptyStateActions([
                CreateAction::make()
                    ->label('Add a character')
                    ->url(route('characters.create'))
                    ->authorize('createAny'),
            ]);
    }
}
