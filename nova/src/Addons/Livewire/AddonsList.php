<?php

declare(strict_types=1);

namespace Nova\Addons\Livewire;

use Anodyne\TablerIcons\Tabler;
use Filament\Actions\Action;
use Filament\Forms\Components\CheckboxList;
use Filament\Support\Enums\Size;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\HtmlString;
use Nova\Addons\Actions\BustActiveAddonsCache;
use Nova\Addons\Actions\DeleteAddon;
use Nova\Addons\Actions\InstallAddon;
use Nova\Addons\Actions\UpdateAddonSettings;
use Nova\Addons\Data\AddonSettings;
use Nova\Addons\Enums\AddonType;
use Nova\Addons\Models\Addon;
use Nova\Addons\Models\Builders\AddonBuilder;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\TextAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Icons\Illustration;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Foundation\Models\Activity;
use Nova\Users\Models\User;
use RalphJSmit\Filament\Activitylog\Filament\Actions\TimelineAction;
use RalphJSmit\Filament\Activitylog\Filament\Infolists\Components\Timeline;
use Spatie\Activitylog\Facades\LogBatch;

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
                    ->searchable(query: fn (AddonBuilder $query, string $search): AddonBuilder => $query->searchFor('name', $search)),
                TextColumn::make('version')
                    ->toggleable(),
                TextColumn::make('location')
                    ->prefix('addons/')
                    ->searchable(query: fn (AddonBuilder $query, string $search): AddonBuilder => $query->searchFor('location', $search))
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
                            ->icon(Tabler::PencilOff)
                            ->label('This add-on was installed from a QuickInstall file and cannot be edited')
                            ->visible(fn (Addon $record): bool => filled($record->repository?->id)),
                    ])->divided(),

                    ActionGroup::make([
                        TimelineAction::make()
                            ->authorize('view')
                            ->modifyTimelineUsing(function (Timeline $timeline): void {
                                $timeline
                                    ->itemIcons([
                                        'installed' => Tabler::Plus->value,
                                        'ran-append' => Tabler::PhotoPlus->value,
                                        'ran-install' => Tabler::Bolt->value,
                                        'ran-migrations' => Tabler::Database->value,
                                        'ran-migrations-rollback' => Tabler::DatabaseOff->value,
                                        'ran-replace' => Tabler::PhotoExclamation->value,
                                        'ran-uninstall' => Tabler::BoltOff->value,
                                    ])
                                    ->itemIconColors([
                                        'installed' => 'success',
                                        'ran-install' => 'primary',
                                        'ran-migrations' => 'success',
                                        'ran-migrations-rollback' => 'warning',
                                        'ran-uninstall' => 'danger',
                                    ])
                                    ->attributeValues([
                                        'status' => fn ($value): string => strtolower($value->getLabel() ?? ''),
                                    ])
                                    ->eventDescriptions([
                                        'ran-append' => fn (Activity $activity): string => __('activity.addons.ran-script', [
                                            'name' => $activity->causer instanceof User ? $activity->causer->name : 'System',
                                            'script' => 'rank image append',
                                        ]),
                                        'ran-install' => fn (Activity $activity): string => __('activity.addons.ran-script', [
                                            'name' => $activity->causer instanceof User ? $activity->causer->name : 'System',
                                            'script' => 'install',
                                        ]),
                                        'ran-migrations' => fn (Activity $activity): string => __('activity.addons.ran-script', [
                                            'name' => $activity->causer instanceof User ? $activity->causer->name : 'System',
                                            'script' => 'database migrations',
                                        ]),
                                        'ran-migrations-rollback' => fn (Activity $activity): string => __('activity.addons.ran-script', [
                                            'name' => $activity->causer instanceof User ? $activity->causer->name : 'System',
                                            'script' => 'database migrations rollback',
                                        ]),
                                        'ran-replace' => fn (Activity $activity): string => __('activity.addons.ran-script', [
                                            'name' => $activity->causer instanceof User ? $activity->causer->name : 'System',
                                            'script' => 'rank image replacement',
                                        ]),
                                        'ran-uninstall' => fn (Activity $activity): string => __('activity.addons.ran-script', [
                                            'name' => $activity->causer instanceof User ? $activity->causer->name : 'System',
                                            'script' => 'uninstall',
                                        ]),
                                        'ran-update' => fn (Activity $activity): string => __('activity.addons.ran-script', [
                                            'name' => $activity->causer instanceof User ? $activity->causer->name : 'System',
                                            'script' => 'update',
                                        ]),
                                    ])
                                    ->modelLabel(Addon::class, 'add-on');
                            }),
                    ])->divided(),

                    ActionGroup::make([
                        Action::make('addonSettings')
                            ->authorize('updateSettings')
                            ->slideOver()
                            ->icon(Tabler::Settings)
                            ->modalWidth(Width::Large)
                            ->modalHeading(fn (Addon $record): string => $record->name.' add-on settings')
                            ->fillForm(fn (Addon $record): array => $record->settings->settings ?? [])
                            ->schema(fn (Addon $record): array => $record->getAddonClass()->settingsForm())
                            ->successNotificationTitle('Add-on settings have been updated')
                            ->action(function (Addon $record, array $data): void {
                                UpdateAddonSettings::run($record, new AddonSettings(settings: $data));
                            }),
                        Action::make('openActionsPanel')
                            ->authorize('runActions')
                            ->slideOver()
                            ->icon(Tabler::Automation)
                            ->modalWidth(Width::ExtraLarge)
                            ->modalHeading('')
                            ->modalSubmitAction(false)
                            ->modalCancelActionLabel('Done')
                            ->modalContent(fn (Addon $record, Action $action): View => view('pages.add-ons.actions', [
                                'record' => $record,
                                'action' => $action,
                            ]))
                            ->registerModalActions($this->actionPanelActions()),
                    ])->divided(),

                    ActionGroup::make([
                        Action::make('goToUpdate')
                            ->icon(Tabler::CloudShare)
                            ->url(fn (Addon $record): ?string => $record->update_url)
                            ->visible(fn (Addon $record): bool => $record->has_update),
                    ])->divided(),

                    ActionGroup::make([
                        DeleteAction::make()
                            ->authorize('delete')
                            ->modalContentView('pages.add-ons.delete')
                            ->successNotificationTitle(fn (Addon $record): string => $record->name.' add-on was deleted')
                            ->using(fn (Addon $record): Addon => DeleteAddon::run($record)),
                    ])->divided(),
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
                    ->icon(Tabler::Sparkles)
                    ->color('gray')
                    ->visible(fn (): bool => Addon::hasInstallableAddons())
                    ->modalWidth(Width::ExtraLarge)->modalIcon()
                    ->modalHeading('')->modalDescription()
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
                            } catch (FileNotFoundException) {
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
            ->emptyStateIcon(Illustration::Addons)
            ->emptyStateHeading('No add-ons found')
            ->emptyStateDescription('Add-ons allow you to personalize and extend Nova to work and behave the way you want.')
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add an add-on')
                    ->url(route('admin.addons.create')),
            ]);
    }

    /**
     * @return list<Action>
     */
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
                ->action(function (Addon $record): void {
                    LogBatch::startBatch();

                    $record->runScript('uninstall');

                    $record->update(['status' => BasicStatus::Inactive]);

                    BustActiveAddonsCache::run();

                    LogBatch::endBatch();

                    Notification::make()->success()
                        ->title('Extension has been uninstalled')
                        ->send();
                }),
            Action::make('extensionUpdate')
                ->color('gray')
                ->size(Size::Small)
                ->label('Update')
                ->action(function (Addon $record): void {
                    LogBatch::startBatch();

                    $record->runScript('update');

                    LogBatch::endBatch();

                    Notification::make()->success()
                        ->title('Extension has been updated')
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
