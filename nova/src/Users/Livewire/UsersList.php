<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
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
                            ->authorize('impersonate')
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
                            ->authorize('delete')
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
                    ->options(fn (): array => User::getStatesFor('status')->flatMap(fn ($state) => [$state => ucfirst($state)])->all()),
                TernaryFilter::make('assigned_characters')
                    ->label('Has assigned characters')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->whereHas('activeCharacters'),
                        false: fn (Builder $query): Builder => $query->whereDoesntHave('activeCharacters')
                    ),
                SelectFilter::make('last_login')
                    ->label('Last signed in')
                    ->options([
                        '7 days' => 'Within 1 week',
                        '14 days' => 'Within 2 weeks',
                        '30 days' => 'In the last month',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when($data['value'], function (Builder $query, string $date): Builder {
                            return $query->whereHas(
                                'latestLogin',
                                fn (Builder $query): Builder => $query->whereBetween('created_at', [now()->sub($date), now()])
                            );
                        });
                    })
                    ->indicateUsing(function (array $data): ?string {
                        if (! $data['value']) {
                            return null;
                        }

                        return 'Last signed in: within '.$data['value'];
                    }),
                SelectFilter::make('last_post')
                    ->label('Last posted')
                    ->options([
                        '7 days' => 'Within 1 week',
                        '14 days' => 'Within 2 weeks',
                        '30 days' => 'In the last month',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when($data['value'], function (Builder $query, string $date): Builder {
                            return $query->whereHas(
                                'latestPost',
                                fn (Builder $query): Builder => $query->whereBetween('published_at', [now()->sub($date), now()])
                            );
                        });
                    })
                    ->indicateUsing(function (array $data): ?string {
                        if (! $data['value']) {
                            return null;
                        }

                        return 'Last posted: within '.$data['value'];
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
