<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Foundation\Models\UserNotificationPreference;

class UserNotificationPreferencesList extends TableComponent
{
    public bool $simple = true;

    public function table(Table $table): Table
    {
        return $table
            ->query(UserNotificationPreference::with('notificationType')->where('user_id', auth()->id()))
            ->groups([
                Group::make('notificationType.audience')
                    ->label('Audience')
                    ->getDescriptionFromRecordUsing(fn (Model $record): ?string => $record->notificationType->audience->description()),
            ])
            ->defaultGroup('notificationType.audience')
            ->defaultPaginationPageOption(25)
            ->columns([
                TextColumn::make('notificationType.name')
                    ->label('Notification')
                    ->titleColumn()
                    ->description(fn (Model $record): ?string => $record->notificationType->description)
                    ->searchable(),
                TextColumn::make('notificationType.audience')
                    ->label('Audience')
                    ->badge()
                    ->color(fn (Model $record): string => $record->notificationType->audience->color()),
                ToggleColumn::make('database')
                    ->label('In-app')
                    ->disabled(fn (Model $record): bool => ! $record->notificationType->database),
                ToggleColumn::make('mail')
                    ->label('Email')
                    ->disabled(fn (Model $record): bool => ! $record->notificationType->mail),
            ])
            ->emptyStateIcon(iconName('notification'))
            ->emptyStateHeading('No notification preferences found');
    }
}
