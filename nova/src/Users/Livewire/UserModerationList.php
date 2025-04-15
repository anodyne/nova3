<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Users\Data\UserModerations;
use Nova\Users\Models\User;

class UserModerationList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::with('media', 'primaryCharacter')
                    ->select([
                        'id',
                        'moderations',
                        'name',
                        'pronouns',
                        'status',
                    ])
                    ->notHidden()
            )
            ->defaultPaginationPageOption(25)
            ->columns([
                ViewColumn::make('name')
                    ->view('filament.tables.columns.user-avatar')
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query->searchFor($search)),
                TextColumn::make('primaryCharacter.name')
                    ->label('Primary character')
                    ->toggleable(),
                ToggleColumn::make('announcements_moderation')
                    ->getStateUsing(fn (User $record): bool => $record->moderations->announcements)
                    ->label('Announcements')
                    ->onColor(fn () => settings('appearance.panda') ? 'panda' : 'primary')
                    ->extraAttributes(['data-panda' => settings('appearance.panda')])
                    ->updateStateUsing(function (User $record, bool $state): void {
                        $record->update([
                            'moderations' => UserModerations::from(announcements: $state, posts: $record->moderations->posts),
                        ]);

                        Notification::make()->success()
                            ->title($record->name.' moderation status updated')
                            ->when($state === true, fn (Notification $notification) => $notification->body('All announcements they author will require approval before being published.'))
                            ->when($state === false, fn (Notification $notification) => $notification->body('Any announcements they author will no longer require approval before being published.'))
                            ->send();
                    }),
                ToggleColumn::make('posts_moderation')
                    ->getStateUsing(fn (User $record): bool => $record->moderations->posts)
                    ->label('Posts')
                    ->onColor(fn () => settings('appearance.panda') ? 'panda' : 'primary')
                    ->extraAttributes(['data-panda' => settings('appearance.panda')])
                    ->updateStateUsing(function (User $record, bool $state): void {
                        $record->update([
                            'moderations' => UserModerations::from(announcements: $record->moderations->announcements, posts: $state),
                        ]);

                        Notification::make()->success()
                            ->title($record->name.' moderation status updated')
                            ->when($state === true, fn (Notification $notification) => $notification->body('All posts they’re involved with will require approval before being published.'))
                            ->when($state === false, fn (Notification $notification) => $notification->body('Any posts they’re involved with will no longer require approval before being published.'))
                            ->send();
                    }),
                TextColumn::make('status')
                    ->badge()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->multiple()
                    ->options(fn (): array => User::getStatesFor('status')->flatMap(fn ($state) => [$state => ucfirst($state)])->all())
                    ->default(fn () => request()->query('status', ['active'])),
            ])
            ->emptyStateIcon(iconName('user'))
            ->emptyStateHeading('No users found');
    }
}
