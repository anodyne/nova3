<?php

declare(strict_types=1);

namespace Nova\Themes\Livewire;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Themes\Actions\CreateTheme;
use Nova\Themes\Actions\DeleteTheme;
use Nova\Themes\Data\ThemeData;
use Nova\Themes\Enums\ThemeStatus;
use Nova\Themes\Events\ThemeInstalled;
use Nova\Themes\Models\Theme;

class ThemesList extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Theme::query())
            ->content(view('filament.tables.themes'))
            ->columns([
                TextColumn::make('name')
                    ->titleColumn()
                    ->searchable(),
                TextColumn::make('location')
                    ->prefix('themes/')
                    ->icon(iconName('folder'))
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (Model $record): string => $record->status->color()),
            ])
            ->actions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make()
                            ->authorize('view')
                            ->url(fn (Model $record): string => route('themes.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Model $record): string => route('themes.edit', $record)),
                    ])->authorizeAny(['view', 'update'])->divided(),

                    ActionGroup::make([
                        DeleteAction::make()
                            ->modalContentView('pages.themes.delete')
                            ->successNotificationTitle(fn (Model $record): string => $record->name.' theme was deleted')
                            ->using(fn (Model $record): Model => DeleteTheme::run($record)),
                    ])->authorize('delete')->divided(),
                ]),
            ])
            ->filters([
                SelectFilter::make('status')->options(ThemeStatus::class),
            ])
            ->heading('Themes')
            ->description('Personalize your public-facing site with a custom theme')
            ->headerActions([
                Action::make('install')
                    ->authorize('create')
                    ->label('Themes available to install')
                    ->link()
                    ->icon(iconName('sparkles'))
                    ->iconSize('md')
                    ->visible(fn () => Theme::hasInstallableThemes())
                    ->modalWidth('xl')
                    ->modalIcon(null)
                    ->modalHeading('')
                    ->modalDescription(null)
                    ->modalSubmitActionLabel('Install')
                    ->modalContent(fn (): View => view('pages.themes.pending-themes'))
                    ->form([
                        CheckboxList::make('themes')
                            ->options(Theme::getInstallableThemes()->flatMap(fn ($theme) => [$theme => $theme]))
                            ->label("Select the pending themes you'd like to install:"),
                    ])
                    ->action(function (array $data): void {
                        $themes = data_get($data, 'themes', []);

                        $created = [];
                        $errored = [];

                        foreach ($themes as $theme) {
                            try {
                                $data = json_decode(Storage::disk('themes')->get("{$theme}/theme.json"), true);

                                $theme = CreateTheme::run(ThemeData::from($data));

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
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add')
                    ->url(route('themes.create')),
            ])
            ->emptyStateIcon(iconName('paint-brush'))
            ->emptyStateHeading('No theme found')
            ->emptyStateDescription("Themes allow you to personalize your public-facing site to reflect your game's personality.")
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add a theme')
                    ->url(route('themes.create')),
            ]);
    }

    public function render()
    {
        return view('livewire.filament-table');
    }
}
