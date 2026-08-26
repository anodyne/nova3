<?php

declare(strict_types=1);

namespace Nova\Characters\Livewire;

use Anodyne\TablerIcons\Tabler;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Nova\Characters\Actions\ActivateCharacter;
use Nova\Characters\Actions\DeactivateCharacter;
use Nova\Characters\Actions\DeleteCharacter;
use Nova\Characters\Actions\ForceDeleteCharacter;
use Nova\Characters\Actions\RestoreCharacter;
use Nova\Characters\Enums\CharacterType;
use Nova\Characters\Events\CharacterActivated;
use Nova\Characters\Events\CharacterDeactivated;
use Nova\Characters\Events\CharacterDeletedByAdmin;
use Nova\Characters\Models\Builders\CharacterBuilder;
use Nova\Characters\Models\Character;
use Nova\Foundation\Filament\Actions\Action;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\BulkAction;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ForceDeleteAction;
use Nova\Foundation\Filament\Actions\ForceDeleteBulkAction;
use Nova\Foundation\Filament\Actions\RestoreAction;
use Nova\Foundation\Filament\Actions\RestoreBulkAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Icons\Illustration;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Foundation\Models\Activity;
use Nova\Users\Models\User;
use RalphJSmit\Filament\Activitylog\Filament\Actions\TimelineAction;
use RalphJSmit\Filament\Activitylog\Filament\Infolists\Components\Timeline;

class CharactersList extends TableComponent
{
    public function table(Table $table): Table
    {
        /** @var User */
        $user = Auth::user();

        return $table
            ->query(
                Character::with('media', 'positions', 'rank.name', 'users', 'activeUsers', 'application.reviews')
                    ->withTrashed()
                    ->notHidden()
                    ->unless(
                        $user->can('manage', new Character),
                        fn (CharacterBuilder $query): CharacterBuilder => $query->isAssignedTo($user)
                    )
                    ->select([
                        'deleted_at',
                        'id',
                        'name',
                        'rank_id',
                        'status',
                        'type',
                    ])
            )
            ->recordUrl(fn (Character $record): string => route('admin.characters.show', $record))
            ->groups([
                Group::make('status')->collapsible(),
                Group::make('type')->collapsible(),
            ])
            ->columns([
                ViewColumn::make('name')
                    ->view('filament.tables.columns.character-avatar')
                    ->searchable(query: fn (CharacterBuilder $query, string $search): CharacterBuilder => $query->searchFor($search)),
                TextColumn::make('activeUsers.name')
                    ->visible($user->can('viewAny', Character::class))
                    ->label('Played by')
                    ->listWithLineBreaks()
                    ->toggleable(),
                TextColumn::make('type')
                    ->badge()
                    ->toggleable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (Character $record): string => $record->trashed() ? 'danger' : $record->status->getColor())
                    ->formatStateUsing(fn (Character $record): string => $record->trashed() ? 'Deleted' : $record->status->getLabel())
                    ->toggleable(),
            ])
            ->recordActions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make()
                            ->authorize('view')
                            ->url(fn (Character $record): string => route('admin.characters.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Character $record): string => route('admin.characters.edit', $record)),
                    ])->divided(),

                    ActionGroup::make([
                        TimelineAction::make()
                            ->modifyTimelineUsing(function (Timeline $timeline): void {
                                $timeline
                                    ->eventDescriptions([
                                        'removed-avatar' => fn (Activity $activity): string => __('activity.characters.removed-avatar', [
                                            'name' => $activity->causer instanceof User ? $activity->causer->name : 'System',
                                        ]),
                                        'uploaded-avatar' => fn (Activity $activity): string => __('activity.characters.uploaded-avatar', [
                                            'name' => $activity->causer instanceof User ? $activity->causer->name : 'System',
                                        ]),
                                    ])
                                    ->itemIcons([
                                        'activated' => Tabler::CircleCheck->value,
                                        'deactivated' => Tabler::CircleMinus->value,
                                    ])
                                    ->itemIconColors([
                                        'activated' => 'success',
                                        'deactivated' => 'warning',
                                    ]);
                            }),
                    ])->divided(),

                    ActionGroup::make([
                        Action::make('activateCharacter')
                            ->authorize('activate')
                            ->icon(Tabler::CircleCheck)
                            ->color('gray')
                            ->modalIconColor('success')
                            ->modalContentView('pages.characters.activate')
                            ->modalSubmitActionLabel('Activate')
                            ->action(function (Character $record): void {
                                $character = ActivateCharacter::run($record);

                                CharacterActivated::dispatch($character);

                                Notification::make()->success()
                                    ->title($record->name.' has been activated')
                                    ->send();
                            }),
                        Action::make('deactivateCharacter')
                            ->authorize('deactivate')
                            ->icon(Tabler::CircleMinus)
                            ->color('gray')
                            ->modalIconColor('danger')
                            ->modalContentView('pages.characters.deactivate')
                            ->modalSubmitActionLabel('Deactivate')
                            ->action(function (Character $record): void {
                                $character = DeactivateCharacter::run($record);

                                CharacterDeactivated::dispatch($character);

                                Notification::make()->success()
                                    ->title($record->name.' has been deactivated')
                                    ->send();
                            }),
                    ])->divided(),

                    ActionGroup::make([
                        Action::make('application')
                            ->label('View application')
                            ->color('gray')
                            ->icon(Tabler::Progress)
                            ->visible(fn (Character $record): bool => Gate::allows('vote', $record->application))
                            ->url(fn (Character $record): string => route('admin.applications.show', $record->application)),
                    ])->visible(fn (Character $record): bool => Gate::allows('vote', $record->application))->divided(),

                    ActionGroup::make([
                        RestoreAction::make()
                            ->authorize('restore')
                            ->modalContentView('pages.characters.restore')
                            ->successNotificationTitle(fn (Character $record): string => $record->name.' was restored')
                            ->using(fn (Character $record): Model => RestoreCharacter::run($record)),
                        DeleteAction::make()
                            ->authorize('delete')
                            ->modalContentView('pages.characters.delete')
                            ->successNotificationTitle(fn (Character $record): string => $record->name.' was deleted')
                            ->action(function (Character $record): void {
                                $character = DeleteCharacter::run($record);

                                CharacterDeletedByAdmin::dispatch($character);
                            }),
                        ForceDeleteAction::make()
                            ->authorize('forceDelete')
                            ->modalContentView('pages.characters.force-delete')
                            ->successNotificationTitle(fn (Character $record): string => $record->name.' was force deleted')
                            ->using(fn (Character $record): Model => ForceDeleteCharacter::run($record)),
                    ])->divided(),
                ]),
            ])
            ->groupedBulkActions([
                BulkAction::make('bulkActivateCharacter')
                    ->authorize('activateAny')
                    ->icon(Tabler::CircleCheck)
                    ->color('gray')
                    ->label('Activate selected')
                    ->modalContentView('pages.characters.activate-bulk')
                    ->modalSubmitActionLabel('Activate')
                    ->deselectRecordsAfterCompletion()
                    ->action(function (Collection $records): void {
                        $recordsCount = $records->count();

                        $records->each(function (Character $record): void {
                            $character = ActivateCharacter::run($record);

                            CharacterActivated::dispatch($character);
                        });

                        Notification::make()->success()
                            ->title($recordsCount.' '.trans_choice('character was|characters were', $recordsCount).' activated')
                            ->send();
                    }),
                BulkAction::make('bulkDeactivateCharacter')
                    ->authorize('deactivateAny')
                    ->icon(Tabler::CircleMinus)
                    ->color('gray')
                    ->label('Deactivate selected')
                    ->modalContentView('pages.characters.deactivate-bulk')
                    ->modalSubmitActionLabel('Deactivate')
                    ->deselectRecordsAfterCompletion()
                    ->action(function (Collection $records): void {
                        $recordsCount = $records->count();

                        $records->each(function (Character $record): void {
                            $character = DeactivateCharacter::run($record);

                            CharacterDeactivated::dispatch($character);
                        });

                        Notification::make()->success()
                            ->title($recordsCount.' '.trans_choice('character was|characters were', $recordsCount).' deactivated')
                            ->send();
                    }),
                RestoreBulkAction::make()
                    ->authorize('restoreAny')
                    ->modalContentView('pages.characters.restore-bulk')
                    ->action(function (Collection $records): void {
                        $records->each(fn (Character $record): Model => RestoreCharacter::run($record));
                    }),
                DeleteBulkAction::make()
                    ->authorize('deleteAny')
                    ->modalContentView('pages.characters.delete-bulk')
                    ->action(function (Collection $records): void {
                        $records->each(function (Character $record): void {
                            $character = DeleteCharacter::run($record);

                            CharacterDeletedByAdmin::dispatch($character);
                        });
                    }),
                ForceDeleteBulkAction::make()
                    ->authorize('deleteAny')
                    ->modalContentView('pages.characters.force-delete-bulk')
                    ->action(function (Collection $records): void {
                        $records->each(fn (Character $record): Model => ForceDeleteCharacter::run($record));
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->multiple()
                    ->options(fn (): array => Character::getStatesFor('status')->flatMap(fn ($state): array => [$state => ucfirst($state)])->all())
                    ->default(fn () => request()->query('status', ['active'])),
                SelectFilter::make('type')
                    ->multiple()
                    ->options(CharacterType::class),
                TernaryFilter::make('only_my_characters')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->whereRelation('users', 'users.id', '=', Auth::id()),
                        false: fn (Builder $query): Builder => $query,
                        blank: fn (Builder $query): Builder => $query
                    )
                    ->default(fn () => request()->query('only_my_characters', false))
                    ->visible($user->can('manage', new Character)),
                TrashedFilter::make()->label('Deleted characters'),
            ])
            ->emptyStateIcon(Illustration::Vulcan)
            ->emptyStateHeading('No characters found')
            ->emptyStateDescription('')
            ->emptyStateActions([
                CreateAction::make()
                    ->label('Add a character')
                    ->url(route('admin.characters.create'))
                    ->authorize('createAny'),
            ]);
    }
}
