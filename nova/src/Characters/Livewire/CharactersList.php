<?php

declare(strict_types=1);

namespace Nova\Characters\Livewire;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
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
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Events\CharacterActivated;
use Nova\Characters\Events\CharacterDeactivated;
use Nova\Characters\Events\CharacterDeletedByAdmin;
use Nova\Characters\Models\Character;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;

class CharactersList extends Component implements HasForms, HasTable
{
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
                            ->icon(iconName('check'))
                            ->color('gray')
                            ->modalHeading('Activate character?')
                            ->modalSubheading(fn (Model $record): string => "Are you sure you want to activate {$record->name}?")
                            ->modalSubmitActionLabel('Activate')
                            ->modalWidth('xl')
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
                            ->modalHeading('Deactivate character?')
                            ->modalSubheading(fn (Model $record): string => "Are you sure you want to deactivate {$record->name}?")
                            ->modalSubmitActionLabel('Deactivate')
                            ->modalWidth('xl')
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
                            ->modalHeading('Delete character?')
                            ->modalSubheading("Are you sure you want to delete this character? You won't be able to recover it.")
                            ->modalSubmitActionLabel('Delete')
                            ->using(function (Model $record): void {
                                $character = DeleteCharacter::run($record);

                                CharacterDeletedByAdmin::dispatch($character);

                                Notification::make()->success()
                                    ->title($record->name.' was deleted')
                                    ->send();
                            }),
                    ])->authorize('delete')->divided(),
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
                    ->options(CharacterType::class),
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
