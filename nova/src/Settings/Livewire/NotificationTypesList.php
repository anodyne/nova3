<?php

declare(strict_types=1);

namespace Nova\Settings\Livewire;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Nova\Foundation\Data\DiscordSettings;
use Nova\Foundation\Enums\NotificationAudience;
use Nova\Foundation\Filament\Actions\Action;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Foundation\Models\NotificationType;
use Nova\Settings\Actions\UpdateSettings;
use Spatie\Html\Facades\Html;

class NotificationTypesList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(NotificationType::query())
            ->groups([
                Group::make('audience')
                    ->getDescriptionFromRecordUsing(fn (Model $record): ?string => $record->audience->description()),
            ])
            ->defaultGroup('audience')
            ->defaultPaginationPageOption(25)
            ->columns([
                TextColumn::make('name')
                    ->titleColumn()
                    ->description(fn (Model $record): ?string => $record->description)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('audience')
                    ->badge()
                    ->color(fn (Model $record): string => $record->audience->color())
                    ->toggleable(),
                ToggleColumn::make('database')->label('Allow in-app')->alignCenter(),
                ToggleColumn::make('mail')->label('Allow email')->alignCenter(),
                ToggleColumn::make('discord')
                    ->label('Allow Discord')
                    ->extraAttributes(fn (Model $record): array => ['class' => $record->audience->canUseDiscord() ? '' : 'hidden'])
                    ->alignCenter(),
            ])
            ->actions([
                ActionGroup::make([
                    ActionGroup::make([
                        Action::make('auditNotification')
                            ->icon(iconName('show'))
                            ->label('User preferences')
                            ->size('lg')
                            ->color('gray')
                            ->modalContentView('pages.settings.notification-user-audit')
                            ->modalSubmitAction(false)
                            ->modalCancelActionLabel('Close'),
                    ])->divided(),

                    ActionGroup::make([
                        Action::make('userDefaults')
                            ->icon(iconName('preferences'))
                            ->label('Default values')
                            ->size('lg')
                            ->color('gray')
                            ->modalContentView('pages.settings.notification-defaults')
                            ->modalSubmitActionLabel('Update')
                            ->fillForm(fn (Model $record): array => [
                                'database_default' => $record->database_default,
                                'mail_default' => $record->mail_default,
                            ])
                            ->form([
                                Toggle::make('database_default')
                                    ->label('In-app')
                                    ->helperText('When triggered, this notification will be sent to the Notifications panel inside of Nova. Any user who has enabled it in their preferences will see an indicator on the notifications icon in the header.'),
                                Toggle::make('mail_default')
                                    ->label('Email')
                                    ->helperText('When triggered, this notification will be emailed to any user who has enabled it in their preferences.'),
                            ])
                            ->visible(fn (Model $record): bool => $record->audience === NotificationAudience::personal)
                            ->action(function (Model $record, ?array $data): void {
                                $record->update([
                                    'database_default' => data_get($data, 'database_default'),
                                    'mail_default' => data_get($data, 'mail_default'),
                                ]);

                                Notification::make()->success()
                                    ->title('User defaults were updated for notification')
                                    ->send();
                            }),

                        Action::make('discordSettings')
                            ->label('Discord settings')
                            ->icon(iconName('discord'))
                            ->size('lg')
                            ->modalWidth('xl')
                            ->color('gray')
                            ->modalContentView('pages.settings.notification-discord-settings')
                            ->fillForm(fn (Model $record): array => [
                                'use_global' => blank($record->discord_settings),
                                'webhook' => $record->discord_settings?->webhook,
                                'color' => $record->discord_settings?->color,
                            ])
                            ->form([
                                Toggle::make('use_global')
                                    ->label('Use global settings')
                                    ->live(),
                                TextInput::make('webhook')
                                    ->label('Discord webhook')
                                    ->helperText(
                                        Html::element('ol')
                                            ->class('list-decimal list-inside space-y-1 px-1')
                                            ->children([
                                                Html::element('li')->text('From your Discord server, go to Server Settings > Integrations > Webhooks'),
                                                Html::element('li')->text('Add a webhook and select the channel notifications should be sent to'),
                                                Html::element('li')->text('Copy the webhook URL and paste it in the field above'),
                                            ])
                                    )
                                    ->hidden(fn (Get $get): bool => $get('use_global') === true),
                                ColorPicker::make('color')
                                    ->label('Accent color')
                                    ->hidden(fn (Get $get): bool => $get('use_global') === true),
                            ])
                            ->action(function (Model $record, ?array $data): void {
                                $useGlobal = data_get($data, 'use_global');

                                $settings = $useGlobal === true ? null : DiscordSettings::from($data);

                                $record->update(['discord_settings' => $settings]);

                                Notification::make()->success()
                                    ->title('Discord settings updated for notification')
                                    ->when($useGlobal, fn (Notification $notification) => $notification->body('The global Discord settings will be used for the '.$record->name.' notification.'))
                                    ->send();
                            })
                            ->hidden(fn (Model $record): bool => $record->audience === NotificationAudience::personal),
                    ])->divided(),
                ]),
            ])
            ->filters([])
            ->heading('Notification settings')
            ->headerActions([
                Action::make('globalDiscordSettings')
                    ->label('Global Discord settings')
                    ->icon(iconName('discord'))
                    ->color('gray')
                    ->modalWidth('xl')
                    ->modalSubmitActionLabel('Update')
                    ->modalContentView('pages.settings.notification-discord-global-settings')
                    ->fillForm([
                        'webhook' => settings('discord.webhook'),
                        'color' => settings('discord.color'),
                    ])
                    ->form([
                        TextInput::make('webhook')
                            ->label('Discord webhook')
                            ->helperText(
                                Html::element('ol')
                                    ->class('list-decimal list-inside space-y-1 px-1')
                                    ->children([
                                        Html::element('li')->text('From your Discord server, go to Server Settings > Integrations > Webhooks'),
                                        Html::element('li')->text('Add a webhook and select the channel notifications should be sent to'),
                                        Html::element('li')->text('Copy the webhook URL and paste it in the field above'),
                                    ])
                            ),
                        ColorPicker::make('color')->label('Accent color'),
                    ])
                    ->action(function (?array $data): void {
                        UpdateSettings::run('discord', DiscordSettings::from($data));

                        Notification::make()->success()
                            ->title('Global discord settings were updated')
                            ->send();
                    }),
                Action::make('findSettings')
                    ->label('Find a setting')
                    ->icon(iconName('search'))
                    ->color('gray')
                    ->action(fn (Component $livewire) => $livewire->dispatch('toggle-spotlight')),
            ])
            ->emptyStateIcon(iconName('write'))
            ->emptyStateHeading('No draft posts found');
    }
}
