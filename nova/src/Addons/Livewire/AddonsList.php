<?php

declare(strict_types=1);

namespace Nova\Addons\Livewire;

use Filament\Actions\Action;
use Filament\Support\Enums\Size;
use Filament\Forms\Components\CheckboxList;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;
use Nova\Addons\Actions\BustActiveAddonsCache;
use Nova\Addons\Actions\DeleteAddon;
use Nova\Addons\Actions\InstallAddon;
use Nova\Addons\Actions\UpdateAddonSettings;
use Nova\Addons\Data\AddonSettings;
use Nova\Addons\Enums\AddonType;
use Nova\Addons\Models\Addon;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\TextAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Livewire\TableComponent;
use RalphJSmit\Filament\Activitylog\Infolists\Components\Timeline;
use RalphJSmit\Filament\Activitylog\Tables\Actions\TimelineAction;
use Spatie\Activitylog\Facades\LogBatch;
use Spatie\Activitylog\Models\Activity;

class AddonsList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Addon::query()
                    ->select([
                        'id',
                        'name',
                        'version',
                        'location',
                        'type',
                        'status',
                        'repository',
                    ])
            )
            ->columns([
                TextColumn::make('name')
                    ->titleColumn()
                    ->description(fn (Addon $record): ?Htmlable => $record->has_update ? new HtmlString('<strong class="text-warning-600 dark:text-warning-500 font-medium text-xs">Version <span class="tabular-nums">'.$record->latest_version.'</span> is available</strong>') : null)
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query->searchFor('name', $search)),
                TextColumn::make('version')
                    ->toggleable(),
                TextColumn::make('location')
                    ->prefix('addons/')
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query->searchFor('location', $search))
                    ->toggleable(),
                TextColumn::make('type')
                    ->badge()
                    ->toggleable(),
                TextColumn::make('repository.type')
                    ->label('Checking version from')
                    ->badge()
                    ->toggleable(),
                TextColumn::make('status')
                    ->badge()
                    ->toggleable(),
            ])
            ->recordActions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make()
                            ->authorize('view')
                            ->url(fn (Addon $record): string => route('admin.addons.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Addon $record): string => route('admin.addons.edit', $record)),
                        TextAction::make('textNotice')
                            ->icon(iconName('edit-off'))
                            ->label('This add-on was installed from a QuickInstall file and cannot be edited')
                            ->visible(fn (Addon $record): bool => filled($record->repository?->id)),
                    ])->authorizeAny(['view', 'update'])->divided(),

                    ActionGroup::make([
                        TimelineAction::make()
                            ->authorize('view')
                            ->modifyTimelineUsing(function (Timeline $timeline) {
                                $timeline
                                    ->itemIcons([
                                        'installed' => icon('add'),
                                        'ran-append' => iconName('image-add'),
                                        'ran-install' => iconName('bolt'),
                                        'ran-migrations' => iconName('database'),
                                        'ran-migrations-rollback' => iconName('database-off'),
                                        'ran-replace' => iconName('image-alert'),
                                        'ran-uninstall' => iconName('bolt-off'),
                                    ])
                                    ->itemIconColors([
                                        'installed' => 'success',
                                        'ran-install' => 'primary',
                                        'ran-migrations' => 'success',
                                        'ran-migrations-rollback' => 'warning',
                                        'ran-uninstall' => 'danger',
                                    ])
                                    ->attributeValues([
                                        'status' => fn ($value) => strtolower($value->getLabel() ?? ''),
                                    ])
                                    ->eventDescriptions([
                                        'ran-append' => fn (Activity $activity) => __('activity.addons.ran-script', [
                                            'name' => $activity->causer->name,
                                            'script' => 'rank image append',
                                        ]),
                                        'ran-install' => fn (Activity $activity) => __('activity.addons.ran-script', [
                                            'name' => $activity->causer->name,
                                            'script' => 'install',
                                        ]),
                                        'ran-migrations' => fn (Activity $activity) => __('activity.addons.ran-script', [
                                            'name' => $activity->causer->name,
                                            'script' => 'database migrations',
                                        ]),
                                        'ran-migrations-rollback' => fn (Activity $activity) => __('activity.addons.ran-script', [
                                            'name' => $activity->causer->name,
                                            'script' => 'database migrations rollback',
                                        ]),
                                        'ran-replace' => fn (Activity $activity) => __('activity.addons.ran-script', [
                                            'name' => $activity->causer->name,
                                            'script' => 'rank image replacement',
                                        ]),
                                        'ran-uninstall' => fn (Activity $activity) => __('activity.addons.ran-script', [
                                            'name' => $activity->causer->name,
                                            'script' => 'uninstall',
                                        ]),
                                        'ran-update' => fn (Activity $activity) => __('activity.addons.ran-script', [
                                            'name' => $activity->causer->name,
                                            'script' => 'update',
                                        ]),
                                    ])
                                    ->modelLabel(Addon::class, 'add-on');
                            }),
                    ])->authorize('view')->divided(),

                    ActionGroup::make([
                        Action::make('addonSettings')
                            ->authorize('update')
                            ->slideOver()
                            ->icon(iconName('settings'))
                            ->modalWidth('lg')
                            ->modalIcon(null)
                            ->modalHeading(fn (Addon $record): string => $record->name.' add-on settings')
                            ->modalDescription(null)
                            ->fillForm(fn (Addon $record): ?array => $record->settings?->settings ?? [])
                            ->schema(fn (Addon $record): ?array => $record->getAddonClass()->settingsForm())
                            ->action(function (Addon $record, array $data) {
                                $settingsData = new AddonSettings(settings: $data);

                                UpdateAddonSettings::run($record, $settingsData);

                                Notification::make()->success()
                                    ->title('Add-on settings have been updated')
                                    ->send();
                            }),
                        Action::make('openActionsPanel')
                            ->authorize('runActions')
                            ->slideOver()
                            ->icon(iconName('automation'))
                            ->modalWidth('xl')
                            ->modalIcon(null)
                            ->modalHeading('')
                            ->modalDescription(null)
                            ->modalSubmitAction(false)
                            ->modalCancelActionLabel('Done')
                            ->modalContent(fn (Addon $record, Action $action): View => view('pages.add-ons.actions', [
                                'record' => $record,
                                'action' => $action,
                            ]))
                            ->registerModalActions($this->actionPanelActions()),
                    ])->authorizeAny(['runActions', 'updateSettings'])->divided(),

                    ActionGroup::make([
                        Action::make('goToUpdate')
                            ->icon(iconName('cloud-share'))
                            ->url(fn (Addon $record): ?string => $record->update_url)
                            ->visible(fn (Addon $record): bool => $record->has_update),
                    ])->authorizeAny(['create', 'update'])->divided(),

                    ActionGroup::make([
                        DeleteAction::make()
                            ->modalContentView('pages.add-ons.delete')
                            ->successNotificationTitle(fn (Addon $record): string => $record->name.' add-on was deleted')
                            ->using(fn (Addon $record): Addon => DeleteAddon::run($record)),
                    ])->authorize('delete')->divided(),
                ]),
            ])
            ->filters([
                SelectFilter::make('type')->options(AddonType::class),
                SelectFilter::make('status')->options(BasicStatus::class),
            ])
            ->headerActions([
                Action::make('install')
                    ->authorize('create')
                    ->label('Add-ons available to install')
                    ->icon(iconName('sparkles'))
                    ->color('gray')
                    ->visible(fn (): bool => Addon::hasInstallableAddons())
                    ->modalWidth('xl')
                    ->modalIcon(null)
                    ->modalHeading('')
                    ->modalDescription(null)
                    ->modalSubmitActionLabel('Install')
                    ->modalContent(fn (Action $action): View => view('pages.add-ons.pending-addons', [
                        'action' => $action,
                    ]))
                    ->schema([
                        CheckboxList::make('addons')
                            ->options(Addon::getInstallableAddons())
                            ->label('Select the pending add-on(s) you’d like to install:'),
                    ])
                    ->action(function (array $data): void {
                        $addons = data_get($data, 'addons', []);

                        $created = [];
                        $errored = [];

                        foreach ($addons as $addon) {
                            try {
                                InstallAddon::run($addon);

                                $created[] = $addon;
                            } catch (FileNotFoundException $ex) {
                                $errored[] = $addon;
                            }
                        }

                        $createdCount = count($created);
                        $erroredCount = count($errored);

                        $notification = Notification::make();

                        if ($createdCount === 0 && $erroredCount > 0) {
                            $notification->danger()
                                ->title(str('add-on')->plural($erroredCount)->title().' could not be installed')
                                ->body('The '.str('add-on')->plural($erroredCount).' '.trans_choice('was|were', $erroredCount).' missing the required QuickInstall file (addon.json). Please add the QuickInstall '.str('file')->plural($erroredCount).' and try again.');
                        }

                        if ($createdCount > 0 && $erroredCount > 0) {
                            $notification->warning()
                                ->title($createdCount.' '.str('add-on')->plural($createdCount).' '.trans_choice('was|were', $createdCount).' installed')
                                ->body($erroredCount.' '.str('add-on')->plural($erroredCount).' '.trans_choice('was|were', $erroredCount).' missing the required QuickInstall file (addon.json). Please add the QuickInstall '.str('file')->plural($erroredCount).' and try again.');
                        }

                        if ($createdCount > 0 && $erroredCount === 0) {
                            $notification->success()
                                ->title($createdCount.' '.str('add-on')->plural($createdCount).' '.trans_choice('was|were', $createdCount).' installed');
                        }

                        $notification->send();
                    }),
            ])
            ->emptyStateIcon(iconName('puzzle'))
            ->emptyStateHeading('No add-ons found')
            ->emptyStateDescription('Add-ons allow you to personalize and extend Nova to work and behave the way you want.')
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add an add-on')
                    ->url(route('admin.addons.create')),
            ]);
    }

    protected function actionPanelActions(): array
    {
        return [
            /**
             * Extension actions
             */
            Action::make('extensionInstall')
                ->color('gray')
                ->size(Size::Small)
                ->label('Install')
                ->action(function (Addon $record): void {
                    LogBatch::startBatch();

                    $record->runScript('install');

                    $record->update(['status' => BasicStatus::Active]);

                    BustActiveAddonsCache::run();

                    LogBatch::endBatch();

                    Notification::make()->success()
                        ->title('Extension has been installed')
                        ->send();
                }),
            Action::make('extensionUninstall')
                ->color('gray')
                ->size(Size::Small)
                ->label('Uninstall')
                ->action(function (Addon $record) {
                    LogBatch::startBatch();

                    $record->runScript('uninstall');

                    $record->update(['status' => BasicStatus::Inactive]);

                    BustActiveAddonsCache::run();

                    LogBatch::endBatch();

                    Notification::make()->success()
                        ->title('Extension has been uninstalled')
                        ->send();
                }),
            Action::make('extensionRunMigrations')
                ->color('gray')
                ->size(Size::Small)
                ->label('Run')
                ->action(function (Addon $record): void {
                    $record->runScript('runMigrations');

                    Notification::make()->success()
                        ->title('Extension database migrations have been run')
                        ->send();
                }),
            Action::make('extensionRollbackMigrations')
                ->color('gray')
                ->size(Size::Small)
                ->label('Rollback')
                ->action(function (Addon $record): void {
                    $record->runScript('rollbackMigrations');

                    Notification::make()->success()
                        ->title('Extension database migrations have been rolled back')
                        ->send();
                }),

            /**
             * Rank set actions
             */
            Action::make('rankSetInstall')
                ->color('gray')
                ->size(Size::Small)
                ->label('Install')
                ->action(function (Addon $record): void {
                    $record->runScript('install');

                    Notification::make()->success()
                        ->title('Rank set has been installed')
                        ->body('Rank set images have been copied from the add-on to the ranks directory.')
                        ->send();
                }),
            Action::make('rankSetUninstall')
                ->color('gray')
                ->size(Size::Small)
                ->label('Uninstall')
                ->action(function (Addon $record): void {
                    $record->runScript('uninstall');

                    Notification::make()->success()
                        ->title('Rank set has been uninstalled')
                        ->body('Rank set images and folders have been removed from ranks directory.')
                        ->send();
                }),
            Action::make('rankSetReplace')
                ->color('gray')
                ->size(Size::Small)
                ->label('Replace')
                ->action(function (Addon $record): void {
                    $record->runScript('replace');

                    Notification::make()->success()
                        ->title('Rank set has been updated')
                        ->body('Rank set images that are named the same have been replaced in the ranks directory.')
                        ->send();
                }),
            Action::make('rankSetAppend')
                ->color('gray')
                ->size(Size::Small)
                ->label('Append')
                ->action(function (Addon $record): void {
                    $record->runScript('append');

                    Notification::make()->success()
                        ->title('Rank set has been updated')
                        ->body('Rank set images that are not named the same have been added to the ranks directory.')
                        ->send();
                }),

            /**
             * Genre actions
             */
            Action::make('genreInstall')
                ->color('gray')
                ->size(Size::Small)
                ->label('Install')
                ->action(function (Addon $record): void {
                    $record->runScript('install');

                    Notification::make()->success()
                        ->title('Genre has been installed')
                        ->body('You will likely need to make significant changes to characters to ensure everything is correct.')
                        ->send();
                }),
            Action::make('genreUpdate')
                ->color('gray')
                ->size(Size::Small)
                ->label('Update')
                ->action(function (Addon $record): void {
                    $record->runScript('update');

                    Notification::make()->success()
                        ->title('Genre has been updated')
                        ->body('You should review your genre data and characters to ensure everything is correct.')
                        ->send();
                }),
            Action::make('genreUninstall')
                ->color('gray')
                ->size(Size::Small)
                ->label('Uninstall')
                ->action(function (Addon $record): void {
                    $record->runScript('uninstall');

                    Notification::make()->success()
                        ->title('Genre has been uninstalled')
                        ->body('There is no longer any genre data available. Your manifest will not display correctly until you have made changes or installed a new genre.')
                        ->send();
                }),
        ];
    }
}
