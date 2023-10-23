<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Nova\Foundation\Filament\Actions\Action;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\BulkAction;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Users\Actions\ActivateUserManager;
use Nova\Users\Actions\DeactivateUser;
use Nova\Users\Actions\DeleteUserManager;
use Nova\Users\Actions\ForcePasswordReset;
use Nova\Users\Events\UserActivated;
use Nova\Users\Events\UserDeactivated;
use Nova\Users\Models\User;

class UsersList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(User::with('media', 'latestLogin', 'latestPost', 'primaryCharacter', 'characters', 'activeCharacters'))
            ->groups([
                Group::make('status')->collapsible(),
            ])
            ->columns([
                ViewColumn::make('name')
                    ->view('filament.tables.columns.user-avatar')
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query->searchFor($search)),
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
                TextColumn::make('updated_at')
                    ->label('Last activity')
                    ->since()
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('latestLogin.created_at')
                    ->label('Last sign in')
                    ->since()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('latestPost.0.published_at')
                    ->label('Last post')
                    ->since()
                    ->sortable()
                    ->toggleable()
                    ->color(fn (mixed $state): ?string => $state->diffInDays(now()) > 14 ? 'danger' : null)
                    ->weight(fn (mixed $state): ?string => $state->diffInDays(now()) > 14 ? 'semibold' : null),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (Model $record): string => $record->status->color())
                    ->formatStateUsing(fn (Model $record): string => $record->status->getLabel())
                    ->toggleable(),
            ])
            ->actions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make()
                            ->authorize('view')
                            ->url(fn (Model $record): string => route('users.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Model $record): string => route('users.edit', $record)),
                    ])->authorizeAny(['view', 'update'])->divided(),

                    ActionGroup::make([
                        Action::make('impersonate')
                            ->modalContentView('pages.users.impersonate-warning')
                            ->modalSubmitActionLabel('Impersonate')
                            ->color('gray')
                            ->icon(iconName('spy'))
                            ->action(fn (Model $record): RedirectResponse => to_route('impersonate', $record->id)),
                    ])->authorize('impersonate')->divided(),

                    ActionGroup::make([
                        Action::make('activate')
                            ->authorize('activate')
                            ->icon(iconName('check'))
                            ->color('gray')
                            ->modalContentView('pages.users.activate')
                            ->modalSubmitActionLabel('Activate')
                            ->form([
                                Checkbox::make('activate_previous_character')
                                    ->label('Activate previous character')
                                    ->default(true),
                            ])
                            ->action(function (Model $record, array $data): void {
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
                            ->icon(iconName('remove'))
                            ->color('gray')
                            ->modalContentView('pages.users.deactivate')
                            ->modalSubmitActionLabel('Deactivate')
                            ->action(function (Model $record): void {
                                DeactivateUser::run($record);

                                UserDeactivated::dispatch($record);

                                Notification::make()->success()
                                    ->title("{$record->name} has been deactivated")
                                    ->send();
                            }),
                    ])->authorizeAny(['activate', 'deactivate'])->divided(),

                    ActionGroup::make([
                        DeleteAction::make()
                            ->modalContentView('pages.users.delete')
                            ->successNotificationTitle('User was deleted')
                            ->using(fn (Model $record): Model => DeleteUserManager::run($record)),
                    ])->authorize('delete')->divided(),
                ]),
            ])
            ->groupedBulkActions([
                BulkAction::make('force-password-reset')
                    ->authorize('updateAny')
                    ->modalContentView('pages.users.force-password-reset-bulk')
                    ->modalSubmitActionLabel('Force password reset')
                    ->icon(iconName('key'))
                    ->color('gray')
                    ->action(function (Collection $records): void {
                        $records = $records
                            ->filter(fn (Model $record): bool => Gate::allows('forcePasswordReset', $record))
                            ->each(fn (Model $record): Model => ForcePasswordReset::run($record));

                        Notification::make()->success()
                            ->title(count($records).' '.trans_choice('user was|users were', count($records)).' updated')
                            ->body("The next time they log in, they'll be prompted to reset their password.")
                            ->send();
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->multiple()
                    ->options(fn (): Collection => User::getStatesFor('status')),
                TernaryFilter::make('assigned_characters')
                    ->label('Has assigned characters')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->whereHas('activeCharacters'),
                        false: fn (Builder $query): Builder => $query->whereDoesntHave('activeCharacters')
                    ),
                Filter::make('latestLogin')
                    ->label('Last signed in')
                    ->form([
                        Select::make('last_login')
                            ->options([
                                '1 week' => '1 week ago',
                                '2 weeks' => '2 weeks ago',
                                '1 month' => '1 month ago',
                            ]),
                    ])
                    ->query(
                        fn (Builder $query, array $data): Builder => $query->when(
                            $data['last_login'],
                            fn (Builder $query, $date): Builder => $query->whereHas(
                                'latestLogin',
                                fn (Builder $query): Builder => $query->where('created_at', '<', now()->sub($date))
                            )
                        )
                    )
                    ->indicateUsing(function (array $data): ?string {
                        if (! $data['last_login']) {
                            return null;
                        }

                        return 'Last signed in: > '.$data['last_login'].' days ago';
                    }),
                Filter::make('latestPost')
                    ->label('Last posted')
                    ->form([
                        Select::make('last_posted')
                            ->options([
                                '1 week' => '1 week ago',
                                '2 weeks' => '2 weeks ago',
                                '1 month' => '1 month ago',
                            ]),
                    ])
                    ->query(
                        fn (Builder $query, array $data): Builder => $query->when(
                            $data['last_posted'],
                            fn (Builder $query, $date): Builder => $query->whereHas(
                                'latestPost',
                                fn (Builder $query): Builder => $query->where('published_at', '<', now()->sub($date))
                            )
                        )
                    )
                    ->indicateUsing(function (array $data): ?string {
                        if (! $data['last_posted']) {
                            return null;
                        }

                        return 'Last posted: > '.$data['last_posted'].' days ago';
                    }),
            ])
            ->heading('Users')
            ->description("Manage all of the game's users")
            ->headerActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add')
                    ->url(route('users.create')),
            ])
            ->emptyStateIcon(iconName('users'))
            ->emptyStateHeading('No users found')
            ->emptyStateDescription('')
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add a user')
                    ->url(route('users.create')),
            ]);
    }
}
