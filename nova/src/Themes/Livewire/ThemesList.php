<?php

declare(strict_types=1);

namespace Nova\Themes\Livewire;

use Filament\Forms\Components\CheckboxList;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\HtmlString;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Themes\Actions\DeleteTheme;
use Nova\Themes\Actions\InstallTheme;
use Nova\Themes\Models\Theme;
use RalphJSmit\Filament\Activitylog\Tables\Actions\TimelineAction;

class ThemesList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(Theme::query())
            ->columns([
                TextColumn::make('name')
                    ->titleColumn()
                    ->description(fn (Theme $record): ?Htmlable => $record->has_update ? new HtmlString('<strong class="text-warning-600 dark:text-warning-500 font-medium text-xs">Version <span class="tabular-nums">'.$record->latest_version.'</span> is available</strong>') : null)
                    ->searchable(),
                TextColumn::make('version')->toggleable(),
                TextColumn::make('location')
                    ->prefix('themes/')
                    ->searchable()
                    ->toggleable(),
                IconColumn::make('is_current_public_theme')
                    ->label('Current theme')
                    ->icon(fn (bool $state): ?string => $state ? iconName('check-circle') : null)
                    ->color(fn (bool $state): ?string => $state ? 'success' : null)
                    ->toggleable(),
                TextColumn::make('repository.type')
                    ->label('Checking version from')
                    ->badge()
                    ->toggleable(),
                TextColumn::make('status')
                    ->badge()
                    ->toggleable(),
            ])
            ->actions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make()
                            ->authorize('view')
                            ->url(fn (Theme $record): string => route('admin.themes.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Theme $record): string => route('admin.themes.edit', $record)),
                    ])->authorizeAny(['view', 'update'])->divided(),

                    ActionGroup::make([
                        TimelineAction::make(),
                    ])->divided(),

                    ActionGroup::make([
                        Action::make('goToUpdate')
                            ->icon(iconName('cloud-share'))
                            ->url(fn (Theme $record): ?string => $record->update_url)
                            ->visible(fn (Theme $record): bool => $record->has_update),
                    ])->authorizeAny(['create', 'update'])->divided(),

                    ActionGroup::make([
                        DeleteAction::make()
                            ->modalContentView('pages.themes.delete')
                            ->successNotificationTitle(fn (Theme $record): string => $record->name.' theme was deleted')
                            ->using(fn (Theme $record): Theme => DeleteTheme::run($record)),
                    ])->authorize('delete')->divided(),
                ]),
            ])
            ->filters([
                SelectFilter::make('status')->options(BasicStatus::class),
            ])
            ->headerActions([
                Action::make('install')
                    ->authorize('create')
                    ->label('Themes available to install')
                    ->icon(iconName('sparkles'))
                    ->color('gray')
                    ->visible(fn (): bool => Theme::hasInstallableThemes())
                    ->modalWidth('xl')
                    ->modalIcon(null)
                    ->modalHeading('')
                    ->modalDescription(null)
                    ->modalSubmitActionLabel('Install')
                    ->modalContent(fn (): View => view('pages.themes.pending-themes'))
                    ->form([
                        CheckboxList::make('themes')
                            ->options(Theme::getInstallableThemes()->flatMap(fn ($theme): array => [$theme => $theme]))
                            ->label('Select the pending themes you’d like to install:'),
                    ])
                    ->action(function (array $data): void {
                        $themes = data_get($data, 'themes', []);

                        $created = [];
                        $errored = [];

                        foreach ($themes as $theme) {
                            try {
                                InstallTheme::run($theme);

                                $created[] = $theme;
                            } catch (FileNotFoundException $ex) {
                                $errored[] = $theme;
                            }
                        }

                        $createdCount = count($created);
                        $erroredCount = count($errored);

                        $notification = Notification::make();

                        if ($createdCount === 0 && $erroredCount > 0) {
                            $notification->danger()
                                ->title(str('theme')->plural($erroredCount)->title().' could not be installed')
                                ->body('The '.str('theme')->plural($erroredCount).' '.trans_choice('was|were', $erroredCount).' missing the required QuickInstall file (theme.json). Please add the QuickInstall '.str('file')->plural($erroredCount).' and try again.');
                        }

                        if ($createdCount > 0 && $erroredCount > 0) {
                            $notification->warning()
                                ->title($createdCount.' '.str('theme')->plural($createdCount).' '.trans_choice('was|were', $createdCount).' installed')
                                ->body($erroredCount.' '.str('theme')->plural($erroredCount).' '.trans_choice('was|were', $erroredCount).' missing the required QuickInstall file (theme.json). Please add the QuickInstall '.str('file')->plural($erroredCount).' and try again.');
                        }

                        if ($createdCount > 0 && $erroredCount === 0) {
                            $notification->success()
                                ->title($createdCount.' '.str('theme')->plural($createdCount).' '.trans_choice('was|were', $createdCount).' installed');
                        }

                        $notification->send();
                    }),
            ])
            ->emptyStateIcon(iconName('paint-brush'))
            ->emptyStateHeading('No theme found')
            ->emptyStateDescription("Themes allow you to personalize your public-facing site to reflect your game's personality.")
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add a theme')
                    ->url(route('admin.themes.create')),
            ]);
    }
}
