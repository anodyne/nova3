<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Anodyne\TablerIcons\Tabler;
use BackedEnum;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Nova\Characters\Models\Character;
use Nova\Foundation\Filament\Actions\Action;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\BulkAction;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Foundation\Models\Activity;
use Nova\Users\Actions\ActivateUser;
use Nova\Users\Actions\ActivateUserManager;
use Nova\Users\Actions\BanUserManager;
use Nova\Users\Actions\DeactivateUser;
use Nova\Users\Actions\DeleteUserManager;
use Nova\Users\Actions\ForcePasswordReset;
use Nova\Users\Data\BanData;
use Nova\Users\Data\PronounsData;
use Nova\Users\Events\UserActivated;
use Nova\Users\Events\UserDeactivated;
use Nova\Users\Models\Builders\UserBuilder;
use Nova\Users\Models\States\Status\Inactive;
use Nova\Users\Models\User;
use RalphJSmit\Filament\Activitylog\Filament\Actions\TimelineAction;
use RalphJSmit\Filament\Activitylog\Filament\Infolists\Components\Timeline;

class UsersList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::with('media', 'latestLogin', 'latestPost', 'primaryCharacter', 'characters', 'activeCharacters', 'application', 'bans')
                    ->notHidden()
            )
            ->recordUrl(fn (User $record): string => route('admin.users.show', $record))
            ->groups([
                Group::make('status')->collapsible(),
            ])
            ->columns([
                ViewColumn::make('name')
                    ->view('filament.tables.columns.user-avatar')
                    ->searchable(query: fn (UserBuilder $query, string $search): UserBuilder => $query->searchFor($search)),
                TextColumn::make('primaryCharacter.name')
                    ->label('Primary character')
                    ->toggleable(),
                TextColumn::make('activeCharacters.name')
                    ->label('Active character(s)')
                    ->listWithLineBreaks()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('characters.name')
                    ->label('Assigned character(s)')
                    ->listWithLineBreaks()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                IconColumn::make('moderations')
                    ->label('Moderated')
                    ->icon(fn (User $record): ?BackedEnum => match ($record->moderations?->isModerated()) {
                        true => Tabler::Forbid2,
                        default => null,
                    })
                    ->color(fn (User $record): ?string => match ($record->moderations?->isModerated()) {
                        true => 'danger',
                        default => null,
                    })
                    ->alignCenter()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->label('Last activity')
                    ->since()
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('latestLogin.created_at')
                    ->label('Last sign in')
                    ->since()
                    ->toggleable(),
                TextColumn::make('latestPost.0.published_at')
                    ->label('Last post')
                    ->since()
                    ->toggleable()
                    ->color(fn (mixed $state): ?string => $state->diffInDays(now()) > 14 ? 'danger' : null)
                    ->weight(fn (mixed $state): ?string => $state->diffInDays(now()) > 14 ? 'semibold' : null),
                TextColumn::make('status')
                    ->badge()
                    ->toggleable(),
            ])
            ->recordActions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make()
                            ->authorize('view')
                            ->url(fn (User $record): string => route('admin.users.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (User $record): string => route('admin.users.edit', $record)),
                    ])->divided(),

                    ActionGroup::make([
                        Action::make('application')
                            ->label('View application')
                            ->color('gray')
                            ->icon(Tabler::Progress)
                            ->url(fn (User $record): string => route('admin.applications.show', $record->application)),
                    ])->visible(fn (User $record): bool => filled($record->application))->divided(),

                    ActionGroup::make([
                        TimelineAction::make()
                            ->modifyTimelineUsing(function (Timeline $timeline): void {
                                $timeline
                                    ->withRelations(['characters'])
                                    ->itemIcon('activated', Tabler::CircleCheck->value)
                                    ->itemIconColor('activated', 'success')
                                    ->itemIcon('deactivated', Tabler::CircleMinus->value)
                                    ->itemIconColor('deactivated', 'warning')
                                    ->eventDescription('assigned', function (Activity $activity) {
                                        $characterIds = $activity->getExtraProperty('characterIds');

                                        $characterNames = Character::whereIn('id', $characterIds)
                                            ->get()
                                            ->implode('name', ', ');

                                        $causer = $activity->causer;
                                        $causerName = $causer instanceof User
                                            ? $causer->name
                                            : 'System';

                                        return str("**{$causerName}** assigned {$characterNames} to the user.")->inlineMarkdown()->toHtmlString();
                                    })
                                    ->eventDescription('unassigned', function (Activity $activity) {
                                        $characterIds = $activity->getExtraProperty('characterIds');

                                        $characterNames = Character::whereIn('id', $characterIds)
                                            ->get()
                                            ->implode('name', ', ');

                                        $causer = $activity->causer;
                                        $causerName = $causer instanceof User
                                            ? $causer->name
                                            : 'System';

                                        return str("**{$causerName}** unassigned {$characterNames} from the user.")->inlineMarkdown()->toHtmlString();
                                    })
                                    ->attributeValue(
                                        'pronouns',
                                        fn (?PronounsData $value): string => (string) $value
                                    );
                            }),
                    ])->divided(),

                    ActionGroup::make([
                        Action::make('impersonate')
                            ->authorize('impersonate')
                            ->modalContentView('pages.users.impersonate-warning')
                            ->modalSubmitActionLabel('Impersonate')
                            ->color('gray')
                            ->icon(Tabler::Spy)
                            ->action(fn (User $record) => to_route('impersonate', $record->id)),
                    ])->divided(),

                    ActionGroup::make([
                        Action::make('activate')
                            ->authorize('activate')
                            ->icon(Tabler::CircleCheck)
                            ->color('gray')
                            ->modalContentView('pages.users.activate')
                            ->modalSubmitActionLabel('Activate')
                            ->schema([
                                Checkbox::make('activate_previous_character')
                                    ->label('Activate previous character')
                                    ->default(true),
                            ])
                            ->action(function (User $record, array $data): void {
                                ActivateUserManager::run(
                                    $record,
                                    activatePreviousCharacter: Arr::boolean($data, 'activate_previous_character')
                                );

                                UserActivated::dispatch($record);

                                Notification::make()->success()
                                    ->title("{$record->name} has been activated")
                                    ->send();
                            }),
                        Action::make('deactivate')
                            ->authorize('deactivate')
                            ->icon(Tabler::CircleMinus)
                            ->color('gray')
                            ->modalContentView('pages.users.deactivate')
                            ->modalSubmitActionLabel('Deactivate')
                            ->action(function (User $record): void {
                                DeactivateUser::run($record);

                                UserDeactivated::dispatch($record);

                                Notification::make()->success()
                                    ->title("{$record->name} has been deactivated")
                                    ->send();
                            }),
                    ])->divided(),

                    ActionGroup::make([
                        Action::make('banUser')
                            ->authorize('update')
                            ->icon(Tabler::Hammer)
                            ->color('gray')
                            ->modalContentView('pages.users.ban')
                            ->successNotificationTitle('User was banned')
                            ->action(function (User $record): void {
                                $banData = BanData::from(
                                    bannable_id: $record->id,
                                );

                                BanUserManager::run($banData);

                                Notification::make()->success()
                                    ->title($record->name.' has been banned')
                                    ->body('The user account has also been deactivated. They will no longer be able to access the site.')
                                    ->send();
                            })
                            ->visible(fn (User $record): bool => $record->isNotBanned()),
                        Action::make('unbanUser')
                            ->authorize('update')
                            ->icon(Tabler::HammerOff)
                            ->color('gray')
                            ->schema([
                                Toggle::make('reactivate')->label('Re-activate their user account'),
                            ])
                            ->modalContentView('pages.users.unban')
                            ->successNotificationTitle('User was unbanned')
                            ->action(function (User $record, array $data): void {
                                DB::transaction(function () use ($record, $data): void {
                                    $record->unban();

                                    if (data_get($data, 'reactivate')) {
                                        ActivateUser::run($record);

                                        $bodyMessage = 'Their user account has been marked as active and they are able to participate again.';
                                    } else {
                                        if ($record->status->canTransitionTo(Inactive::class)) {
                                            $record->status->transitionTo(Inactive::class);

                                            $bodyMessage = 'Their user account is still marked as inactive. If you want them to be able to participate again, you will need to activate their account.';
                                        } else {
                                            $bodyMessage = null;
                                        }
                                    }

                                    activity()
                                        ->performedOn($record)
                                        ->event('unbanned')
                                        ->log('unbanned');

                                    Notification::make()->success()
                                        ->title($record->name.' has been un-banned')
                                        ->body($bodyMessage)
                                        ->send();
                                });
                            })
                            ->visible(fn (User $record): bool => $record->isBanned()),
                    ])->divided(),

                    ActionGroup::make([
                        DeleteAction::make()
                            ->authorize('delete')
                            ->modalContentView('pages.users.delete')
                            ->successNotificationTitle('User was deleted')
                            ->using(fn (User $record): Model => DeleteUserManager::run($record)),
                    ])->divided(),
                ]),
            ])
            ->groupedBulkActions([
                BulkAction::make('forcePasswordReset')
                    ->authorize('updateAny')
                    ->modalContentView('pages.users.force-password-reset-bulk')
                    ->modalSubmitActionLabel('Force password reset')
                    ->icon(Tabler::Key)
                    ->color('gray')
                    ->action(function (Collection $records): void {
                        $records = $records
                            ->filter(fn (User $record): bool => Gate::allows('forcePasswordReset', $record))
                            ->each(fn (User $record): Model => ForcePasswordReset::run($record));

                        Notification::make()->success()
                            ->title(count($records).' '.trans_choice('user was|users were', count($records)).' updated')
                            ->body("The next time they log in, they'll be prompted to reset their password.")
                            ->send();
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->multiple()
                    ->options(fn (): array => User::getStatesFor('status')->flatMap(fn ($state): array => [$state => ucfirst($state)])->all())
                    ->default(fn () => request()->query('status', ['active'])),
                TernaryFilter::make('hasAssignedCharacters')
                    ->label('Has assigned characters')
                    ->queries(
                        true: fn (UserBuilder $query): UserBuilder => $query->whereHas('activeCharacters'),
                        false: fn (UserBuilder $query): UserBuilder => $query->whereDoesntHave('activeCharacters')
                    ),
                TernaryFilter::make('moderated')
                    ->label('Is moderated')
                    ->queries(
                        true: fn (UserBuilder $query): UserBuilder => $query->whereModerationHasTrue(),
                        false: fn (UserBuilder $query): UserBuilder => $query->whereModerationDoesntHaveTrue()
                    ),
                SelectFilter::make('lastLogin')
                    ->label('Last signed in')
                    ->options([
                        '7 days' => 'Within 1 week',
                        '14 days' => 'Within 2 weeks',
                        '30 days' => 'In the last month',
                    ])
                    ->query(fn (UserBuilder $query, array $data): UserBuilder => $query->when($data['value'], fn (Builder $query, string $date): Builder => $query->whereHas(
                        'latestLogin',
                        fn (Builder $query): Builder => $query->whereBetween('created_at', [now()->sub($date), now()])
                    )))
                    ->indicateUsing(function (array $data): ?string {
                        if (! $data['value']) {
                            return null;
                        }

                        return 'Last signed in: within '.$data['value'];
                    }),
                SelectFilter::make('lastPost')
                    ->label('Last posted')
                    ->options([
                        '7 days' => 'Within 1 week',
                        '14 days' => 'Within 2 weeks',
                        '30 days' => 'In the last month',
                    ])
                    ->query(fn (UserBuilder $query, array $data): UserBuilder => $query->when($data['value'], fn (Builder $query, string $date): Builder => $query->whereHas(
                        'latestPost',
                        fn (Builder $query): Builder => $query->whereBetween('published_at', [now()->sub($date), now()])
                    )))
                    ->indicateUsing(function (array $data): ?string {
                        if (! $data['value']) {
                            return null;
                        }

                        return 'Last posted: within '.$data['value'];
                    }),
            ])
            ->emptyStateIcon(Tabler::Users)
            ->emptyStateHeading('No users found')
            ->emptyStateDescription('')
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add a user')
                    ->url(route('admin.users.create')),
            ]);
    }
}
