<?php

declare(strict_types=1);

namespace Nova\Characters\Livewire;

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
use Nova\Foundation\Livewire\TableComponent;
use RalphJSmit\Filament\Activitylog\Infolists\Components\Timeline;
use RalphJSmit\Filament\Activitylog\Tables\Actions\TimelineAction;
use Spatie\Activitylog\Models\Activity;

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
                        fn (Builder $query): Builder => $query->isAssignedTo($user)
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
            ->groups([
                Group::make('status')->collapsible(),
                Group::make('type')->collapsible(),
            ])
            ->columns([
                ViewColumn::make('name')
                    ->view('filament.tables.columns.character-avatar')
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query->searchFor($search)),
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
                    ])->authorizeAny(['view', 'update'])->divided(),

                    ActionGroup::make([
                        TimelineAction::make()
                            ->modifyTimelineUsing(function (Timeline $timeline) {
                                $timeline
                                    ->eventDescriptions([
                                        'removed-avatar' => fn (Activity $activity) => __('activity.characters.removed-avatar', [
                                            'name' => $activity->causer->name,
                                        ]),
                                        'uploaded-avatar' => fn (Activity $activity) => __('activity.characters.uploaded-avatar', [
                                            'name' => $activity->causer->name,
                                        ]),
                                    ])
                                    ->itemIcons([
                                        'activated' => iconName('check'),
                                        'deactivated' => iconName('remove'),
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
                            ->icon(iconName('check'))
                            ->color('gray')
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
                            ->icon(iconName('remove'))
                            ->color('gray')
                            ->modalContentView('pages.characters.deactivate')
                            ->modalSubmitActionLabel('Deactivate')
                            ->action(function (Character $record): void {
                                $character = DeactivateCharacter::run($record);

                                CharacterDeactivated::dispatch($character);

                                Notification::make()->success()
                                    ->title($record->name.' has been deactivated')
                                    ->send();
                            }),
                    ])->authorizeAny(['activate', 'deactivate'])->divided(),

                    ActionGroup::make([
                        Action::make('application')
                            ->label('View application')
                            ->color('gray')
                            ->icon(iconName('progress'))
                            ->visible(fn (Character $record): bool => Gate::allows('vote', $record->application))
                            ->url(fn (Character $record): ?string => route('admin.applications.show', $record->application)),
                    ])->visible(fn (Character $record): bool => Gate::allows('vote', $record->application))->divided(),

                    ActionGroup::make([
                        RestoreAction::make()
                            ->authorize('restore')
                            ->modalContentView('pages.characters.restore')
                            ->action(function (Character $record): void {
                                RestoreCharacter::run($record);

                                Notification::make()->success()
                                    ->title($record->name.' was restored')
                                    ->send();
                            }),
                        DeleteAction::make()
                            ->authorize('delete')
                            ->modalContentView('pages.characters.delete')
                            ->action(function (Character $record): void {
                                $character = DeleteCharacter::run($record);

                                CharacterDeletedByAdmin::dispatch($character);

                                Notification::make()->success()
                                    ->title($record->name.' was deleted')
                                    ->send();
                            }),
                        ForceDeleteAction::make()
                            ->authorize('forceDelete')
                            ->modalContentView('pages.characters.force-delete')
                            ->action(function (Character $record): void {
                                ForceDeleteCharacter::run($record);

                                Notification::make()->success()
                                    ->title($record->name.' was force deleted')
                                    ->send();
                            }),
                    ])->authorizeAny(['delete', 'forceDelete', 'restore'])->divided(),
                ]),
            ])
            ->groupedBulkActions([
                BulkAction::make('bulkActivateCharacter')
                    ->authorize('activateAny')
                    ->icon(iconName('check'))
                    ->color('gray')
                    ->label('Activate selected')
                    ->modalContentView('pages.characters.activate-bulk')
                    ->modalSubmitActionLabel('Activate')
                    ->deselectRecordsAfterCompletion()
                    ->action(function (Collection $records): void {
                        $ignoredRecords = 0;

                        $records = $records
                            ->filter(function (Character $record) use (&$ignoredRecords): bool {
                                if (Gate::allows('activate', $record)) {
                                    return true;
                                }

                                $ignoredRecords += 1;

                                return false;
                            })
                            ->each(function (Character $record): void {
                                $character = ActivateCharacter::run($record);

                                CharacterActivated::dispatch($character);
                            });

                        Notification::make()->success()
                            ->title(count($records).' '.trans_choice('character was|characters were', count($records)).' activated')
                            ->when($ignoredRecords > 0, function (Notification $notification) use ($ignoredRecords) {
                                return $notification->body(sprintf(
                                    '%d %s ignored due to being ineligible for this action.',
                                    $ignoredRecords,
                                    trans_choice('record was|records were', $ignoredRecords)
                                ));
                            })
                            ->send();
                    }),
                BulkAction::make('bulkDeactivateCharacter')
                    ->authorize('deactivateAny')
                    ->icon(iconName('remove'))
                    ->color('gray')
                    ->label('Deactivate selected')
                    ->modalContentView('pages.characters.deactivate-bulk')
                    ->modalSubmitActionLabel('Deactivate')
                    ->deselectRecordsAfterCompletion()
                    ->action(function (Collection $records): void {
                        $ignoredRecords = 0;

                        $records = $records
                            ->filter(function (Character $record) use (&$ignoredRecords): bool {
                                if (Gate::allows('deactivate', $record)) {
                                    return true;
                                }

                                $ignoredRecords += 1;

                                return false;
                            })
                            ->each(function (Character $record): void {
                                $character = DeactivateCharacter::run($record);

                                CharacterDeactivated::dispatch($character);
                            });

                        Notification::make()->success()
                            ->title(count($records).' '.trans_choice('character was|characters were', count($records)).' deactivated')
                            ->when($ignoredRecords > 0, function (Notification $notification) use ($ignoredRecords) {
                                return $notification->body(sprintf(
                                    '%d %s ignored due to being ineligible for this action.',
                                    $ignoredRecords,
                                    trans_choice('record was|records were', $ignoredRecords)
                                ));
                            })
                            ->send();
                    }),
                RestoreBulkAction::make()
                    ->authorize('restoreAny')
                    ->modalContentView('pages.characters.restore-bulk')
                    ->action(function (Collection $records): void {
                        $ignoredRecords = 0;

                        $records = $records
                            ->filter(function (Character $record) use (&$ignoredRecords): bool {
                                if (Gate::allows('restore', $record)) {
                                    return true;
                                }

                                $ignoredRecords += 1;

                                return false;
                            })
                            ->each(fn (Character $record): Model => RestoreCharacter::run($record));

                        Notification::make()->success()
                            ->title(count($records).' '.trans_choice('character was|characters were', count($records)).' restored')
                            ->when($ignoredRecords > 0, function (Notification $notification) use ($ignoredRecords) {
                                return $notification->body(sprintf(
                                    '%d %s ignored due to being ineligible for this action.',
                                    $ignoredRecords,
                                    trans_choice('record was|records were', $ignoredRecords)
                                ));
                            })
                            ->send();
                    }),
                DeleteBulkAction::make()
                    ->authorize('deleteAny')
                    ->modalContentView('pages.characters.delete-bulk')
                    ->action(function (Collection $records): void {
                        $ignoredRecords = 0;

                        $records = $records
                            ->filter(function (Character $record) use (&$ignoredRecords): bool {
                                if (Gate::allows('delete', $record)) {
                                    return true;
                                }

                                $ignoredRecords += 1;

                                return false;
                            })
                            ->each(function (Character $record): void {
                                $character = DeleteCharacter::run($record);

                                CharacterDeletedByAdmin::dispatch($character);
                            });

                        Notification::make()->success()
                            ->title(count($records).' '.trans_choice('character was|characters were', count($records)).' deleted')
                            ->when($ignoredRecords > 0, function (Notification $notification) use ($ignoredRecords) {
                                return $notification->body(sprintf(
                                    '%d %s ignored due to being ineligible for this action.',
                                    $ignoredRecords,
                                    trans_choice('record was|records were', $ignoredRecords)
                                ));
                            })
                            ->send();
                    }),
                ForceDeleteBulkAction::make()
                    ->authorize('deleteAny')
                    ->modalContentView('pages.characters.force-delete-bulk')
                    ->action(function (Collection $records): void {
                        $ignoredRecords = 0;

                        $records = $records
                            ->filter(function (Character $record) use (&$ignoredRecords): bool {
                                if (Gate::allows('forceDelete', $record)) {
                                    return true;
                                }

                                $ignoredRecords += 1;

                                return false;
                            })
                            ->each(fn (Character $record): Model => ForceDeleteCharacter::run($record));

                        Notification::make()->success()
                            ->title(count($records).' '.trans_choice('character was|characters were', count($records)).' force deleted')
                            ->when($ignoredRecords > 0, function (Notification $notification) use ($ignoredRecords) {
                                return $notification->body(sprintf(
                                    '%d %s ignored due to being ineligible for this action.',
                                    $ignoredRecords,
                                    trans_choice('record was|records were', $ignoredRecords)
                                ));
                            })
                            ->send();
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->multiple()
                    ->options(fn (): array => Character::getStatesFor('status')->flatMap(fn ($state) => [$state => ucfirst($state)])->all())
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
            ->emptyStateIcon(iconName('characters'))
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
