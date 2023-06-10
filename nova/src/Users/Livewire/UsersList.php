<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
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
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Livewire\Component;
use Nova\Foundation\Filament\Actions;
use Nova\Users\Actions\ActivateUser;
use Nova\Users\Actions\ActivateUserPreviousCharacter;
use Nova\Users\Actions\DeactivateUser;
use Nova\Users\Actions\DeleteUser;
use Nova\Users\Actions\ForcePasswordReset;
use Nova\Users\Events\UserActivated;
use Nova\Users\Events\UserDeactivated;
use Nova\Users\Models\User;

class UsersList extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(User::with('media', 'latestLogin', 'latestPost', 'primaryCharacter', 'characters', 'activeCharacters'))
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
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('characters.name')
                    ->label('Assigned character(s)')
                    ->listWithLineBreaks()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Last activity')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Actions\ActionGroup::make([
                    Actions\ActionGroup::make([
                        Actions\ViewAction::make()
                            ->authorize('view')
                            ->url(fn (Model $record): string => route('users.show', $record)),
                        Actions\EditAction::make()
                            ->authorize('update')
                            ->url(fn (Model $record): string => route('users.edit', $record)),
                    ])->authorizeAny(['view', 'update'])->divided(),
                    Actions\ActionGroup::make([
                        Action::make('activate')
                            ->authorize('activate')
                            ->icon(iconName('check'))
                            ->color('gray')
                            ->form([
                                Checkbox::make('activate_previous_character')
                                    ->label('Activate previous character')
                                    ->default(true),
                            ])
                            ->modalHeading('Activate user?')
                            ->modalSubheading(
                                fn (Model $record): string => "Are you sure you want to activate {$record->name}? You can choose below whether to activate the user's previous character as well."
                            )
                            ->modalSubmitActionLabel('Activate')
                            ->modalWidth('lg')
                            ->action(function (Model $record, array $data): void {
                                ActivateUser::run($record);

                                if (data_get($data, 'activate_previous_character') === true) {
                                    ActivateUserPreviousCharacter::run($record);
                                }

                                dispatch(new UserActivated($record));

                                Notification::make()->success()
                                    ->title("{$record->name} has been activated")
                                    ->send();
                            }),
                        Action::make('deactivate')
                            ->authorize('deactivate')
                            ->icon(iconName('remove'))
                            ->color('gray')
                            ->requiresConfirmation()
                            ->modalHeading('Deactivate user?')
                            ->modalSubheading(
                                fn (Model $record): string => "Are you sure you want to deactivate {$record->name}? This will also deactivate all characters assigned to the user who are not jointly owned with another user."
                            )
                            ->modalSubmitActionLabel('Deactivate')
                            ->modalWidth('lg')
                            ->action(function (Model $record): void {
                                DeactivateUser::run($record);

                                dispatch(new UserDeactivated($record));

                                Notification::make()->success()
                                    ->title("{$record->name} has been deactivated")
                                    ->send();
                            }),
                    ])->authorizeAny(['activate', 'deactivate'])->divided(),
                    Actions\ActionGroup::make([
                        Actions\DeleteAction::make()
                            ->close()
                            ->modalHeading('Delete user?')
                            ->modalSubheading(
                                fn (Model $record): string => "Are you sure you want to delete {$record->name}? You won't be able to recover the user record."
                            )
                            ->modalSubmitActionLabel('Delete')
                            ->successNotificationTitle('User was deleted')
                            ->using(fn (Model $record): Model => DeleteUser::run($record)),
                    ])->authorize('delete')->divided(),
                ]),
            ])
            ->groupedBulkActions([
                BulkAction::make('force-password-reset')
                    ->authorize('updateAny')
                    ->requiresConfirmation()
                    ->icon(iconName('key'))
                    ->color('gray')
                    ->modalHeading('Force password reset?')
                    ->action(
                        fn (Collection $records): Collection => $records->each(
                            fn (Model $record): Model => ForcePasswordReset::run($record)
                        )
                    ),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->multiple()
                    ->options(fn () => User::getStatesFor('status')),
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
                            fn (Builder $query, $date) => $query->whereHas(
                                'latestLogin',
                                fn (Builder $query) => $query->where('created_at', '<', now()->sub($date))
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
                            fn (Builder $query, $date) => $query->whereHas(
                                'latestPost',
                                fn (Builder $query) => $query->where('published_at', '<', now()->sub($date))
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
            ->groups([
                Group::make('status')->collapsible(),
            ])
            ->heading('Users')
            ->description("Manage all of the game's users")
            ->headerActions([
                Actions\CreateAction::make()
                    ->authorize('create')
                    ->label('Add')
                    ->url(route('users.create')),
            ])
            ->emptyStateIcon(iconName('users'))
            ->emptyStateHeading('No users found')
            ->emptyStateActions([
                Actions\CreateAction::make()
                    ->authorize('create')
                    ->label('Add a user')
                    ->url(route('users.create')),
            ]);
    }

    public function render()
    {
        return view('livewire.filament-table');
    }
}
