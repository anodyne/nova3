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
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Settings\Data\FontFamilies;
use Nova\Themes\Actions\CreateTheme;
use Nova\Themes\Actions\DeleteTheme;
use Nova\Themes\Data\ThemeData;
use Nova\Themes\Data\ThemeSettings;
use Nova\Themes\Enums\ThemeStatus;
use Nova\Themes\Events\ThemeInstalled;
use Nova\Themes\Models\Theme;

class ThemesList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(Theme::query())
            ->columns([
                TextColumn::make('name')
                    ->titleColumn()
                    ->searchable(),
                TextColumn::make('location')
                    ->prefix('themes/')
                    ->searchable()
                    ->toggleable(),
                IconColumn::make('is_current_public_theme')
                    ->label('Current theme')
                    ->icon(fn (bool $state): ?string => $state ? iconName('check') : null)
                    ->color(fn (bool $state): ?string => $state ? 'success' : null)
                    ->toggleable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (Theme $record): string => $record->status->color())
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
                        DeleteAction::make()
                            ->modalContentView('pages.themes.delete')
                            ->successNotificationTitle(fn (Theme $record): string => $record->name.' theme was deleted')
                            ->using(fn (Theme $record): Theme => DeleteTheme::run($record)),
                    ])->authorize('delete')->divided(),
                ]),
            ])
            ->filters([
                SelectFilter::make('status')->options(ThemeStatus::class),
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
                                $data = json_decode(Storage::disk('themes')->get("{$theme}/theme.json"), true);

                                $theme = CreateTheme::run(new ThemeData(
                                    name: data_get($data, 'name'),
                                    location: data_get($data, 'location'),
                                    credits: data_get($data, 'credits'),
                                    status: ThemeStatus::active,
                                    preview: data_get($data, 'preview'),
                                    settings: new ThemeSettings(
                                        fonts: new FontFamilies(
                                            headerProvider: 'local',
                                            headerFamily: 'Geist',
                                            bodyProvider: 'local',
                                            bodyFamily: 'Inter',
                                        ),
                                        settings: []
                                    )
                                ));

                                ThemeInstalled::dispatch($theme);

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
