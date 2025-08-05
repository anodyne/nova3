<?php

declare(strict_types=1);

namespace Nova\Roles\Livewire;

use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ReplicateAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Icons\Icon;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Roles\Actions\DeleteRole;
use Nova\Roles\Actions\DuplicateRole;
use Nova\Roles\Data\RoleData;
use Nova\Roles\Events\RoleDuplicated;
use Nova\Roles\Models\Role;
use RalphJSmit\Filament\Activitylog\Filament\Actions\TimelineAction;

class RolesList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Role::query()
                    ->with('user', 'permissions')
                    ->select([
                        'display_name',
                        'id',
                        'is_default',
                        'is_locked',
                        'order_column',
                    ])
            )
            ->defaultSort('order_column')
            ->reorderable('order_column')
            ->columns([
                TextColumn::make('display_name')
                    ->titleColumn()
                    ->label('Name')
                    ->icon(fn (Role $record): ?Icon => $record->is_locked ? Icon::LockClosed : null)
                    ->iconPosition('after')
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query->searchFor($search)),
                TextColumn::make('user_count')
                    ->counts('user')
                    ->label('# of active users')
                    ->alignCenter()
                    ->toggleable(),
                TextColumn::make('permissions_count')
                    ->counts('permissions')
                    ->label('# of permissions')
                    ->alignCenter()
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                // FIXME: This should be able to use null for the falseIcon
                IconColumn::make('is_default')
                    ->label('Assigned to new users')
                    ->alignCenter()
                    ->trueIcon(Icon::CheckCircle)
                    ->falseIcon(Icon::XmarkCircle),
            ])
            ->recordActions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make()
                            ->authorize('view')
                            ->url(fn (Role $record): string => route('admin.roles.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Role $record): string => route('admin.roles.edit', $record)),
                    ])->divided(),

                    ActionGroup::make([
                        TimelineAction::make(),
                    ])->divided(),

                    ActionGroup::make([
                        ReplicateAction::make()
                            ->authorize('duplicate')
                            ->modalContentView('pages.roles.duplicate')
                            ->schema([
                                TextInput::make('display_name')->label('New role name'),
                            ])
                            ->action(function (Role $record, array $data): void {
                                $replica = DuplicateRole::run(
                                    $record,
                                    RoleData::from(
                                        displayName: $displayName = data_get($data, 'display_name'),
                                        name: str($displayName)->slug(),
                                        isDefault: false
                                    )
                                );

                                RoleDuplicated::dispatch($replica, $record);

                                Notification::make()->success()
                                    ->title("{$replica->display_name} role has been created")
                                    ->body('Any permissions assigned to the '.$record->display_name.' role have been added to your new role.')
                                    ->send();
                            }),
                    ])->divided(),

                    ActionGroup::make([
                        DeleteAction::make()
                            ->authorize('delete')
                            ->modalContentView('pages.roles.delete')
                            ->successNotificationTitle(fn (Role $record): string => $record->display_name.' role was deleted')
                            ->using(fn (Role $record): Model => DeleteRole::run($record)),
                    ])->divided(),
                ]),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->authorize('deleteAny')
                    ->modalContentView('pages.roles.delete-bulk')
                    ->action(function (Collection $records): void {
                        $ignoredRecords = 0;

                        $records = $records
                            ->filter(function (Role $record) use (&$ignoredRecords): bool {
                                if (Gate::allows('delete', $record)) {
                                    return true;
                                }

                                $ignoredRecords += 1;

                                return false;
                            })
                            ->each(fn (Role $record): Model => DeleteRole::run($record));

                        Notification::make()->success()
                            ->title(count($records).' '.trans_choice('role was|roles were', count($records)).' deleted')
                            ->when($ignoredRecords > 0, function (Notification $notification) use ($ignoredRecords) {
                                return $notification->body(sprintf(
                                    '%d %s ignored due to being ineligible for this action.',
                                    $ignoredRecords,
                                    trans_choice('record was|records were', $ignoredRecords)
                                ));
                            })
                            ->send();
                    }),
            ])
            ->filters([
                TernaryFilter::make('is_default')
                    ->label('Assigned to new users')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->where('is_default', true),
                        false: fn (Builder $query): Builder => $query->where('is_default', false),
                    ),
                TernaryFilter::make('has_permissions')
                    ->label('Has assigned permissions')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->whereHas('permissions'),
                        false: fn (Builder $query): Builder => $query->whereDoesntHave('permissions'),
                    ),
                TernaryFilter::make('has_users')
                    ->label('Has assigned users')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->whereHas('user'),
                        false: fn (Builder $query): Builder => $query->whereDoesntHave('user'),
                    ),
            ])
            ->header(fn (): ?View => $this->isTableReordering() ? view('filament.tables.roles-reordering-notice') : null)
            ->emptyStateIcon(Icon::Shield)
            ->emptyStateHeading('No roles found')
            ->emptyStateDescription('Roles allow you to control what users can and cannot access throughout Nova.')
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add a role')
                    ->url(route('admin.roles.create')),
            ]);
    }
}
