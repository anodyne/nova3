<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Anodyne\TablerIcons\Tabler;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Users\Models\UserNotificationPreference;

class UserNotificationPreferencesList extends TableComponent
{
    public bool $simple = true;

    public function table(Table $table): Table
    {
        return $table
            ->query(UserNotificationPreference::with('notificationType')->where('user_id', Auth::id()))
            ->groups([
                Group::make('notificationType.audience')
                    ->label('Audience')
                    ->getDescriptionFromRecordUsing(fn (UserNotificationPreference $record): string => $record->notificationType->audience->description()),
            ])
            ->defaultGroup('notificationType.audience')
            ->defaultPaginationPageOption(25)
            ->columns([
                TextColumn::make('notificationType.name')
                    ->label('Notification')
                    ->titleColumn()
                    ->description(fn (UserNotificationPreference $record): ?string => $record->notificationType->description)
                    ->searchable(),
                TextColumn::make('notificationType.audience')
                    ->label('Audience')
                    ->badge()
                    ->color(fn (UserNotificationPreference $record): string => $record->notificationType->audience->color()),
                ToggleColumn::make('database')
                    ->label('In-app')
                    ->onColor(fn (): string => settings('appearance.panda') ? 'panda' : 'primary')
                    ->extraAttributes(['data-panda' => settings('appearance.panda')])
                    ->disabled(fn (UserNotificationPreference $record): bool => ! $record->notificationType->database),
                ToggleColumn::make('mail')
                    ->label('Email')
                    ->onColor(fn (): string => settings('appearance.panda') ? 'panda' : 'primary')
                    ->extraAttributes(['data-panda' => settings('appearance.panda')])
                    ->disabled(fn (UserNotificationPreference $record): bool => ! $record->notificationType->mail),
            ])
            ->emptyStateIcon(Tabler::Notification)
            ->emptyStateHeading('No notification preferences found');
    }
}
