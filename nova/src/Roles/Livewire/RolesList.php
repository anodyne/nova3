<?php

declare(strict_types=1);

namespace Nova\Roles\Livewire;

use Anodyne\TablerIcons\Tabler;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ReplicateAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Foundation\Icons\Illustration;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Roles\Actions\DeleteRole;
use Nova\Roles\Actions\DuplicateRole;
use Nova\Roles\Data\RoleData;
use Nova\Roles\Events\RoleDuplicated;
use Nova\Roles\Models\Builders\RoleBuilder;
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
                        'description',
                        'display_name',
                        'id',
                        'is_default',
                        'is_locked',
                        'order_column',
                    ])
            )
            ->recordUrl(fn (Role $record): string => route('admin.roles.show', $record))
            ->defaultSort('order_column')
            ->reorderable('order_column')
            ->columns([
                TextColumn::make('display_name')
                    ->titleColumn()
                    ->label('Name')
                    ->icon(fn (Role $record): ?BackedEnum => $record->is_locked ? Tabler::Lock : null)
                    ->iconPosition('after')
                    ->searchable(query: fn (RoleBuilder $query, string $search): RoleBuilder => $query->searchFor($search)),
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
                IconColumn::make('is_default')
                    ->label('Assigned to new users')
                    ->alignCenter()
                    ->trueIcon(Tabler::CircleCheck)
                    ->falseIcon(''),
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
                                $displayName = data_get($data, 'display_name');

                                $replica = DuplicateRole::run(
                                    $record,
                                    RoleData::from(
                                        name: str($displayName)->slug()->toString(),
                                        displayName: $displayName,
                                        description: $record->description,
                                        isDefault: false
                                    )
                                );

                                RoleDuplicated::dispatch($replica, $record);
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
                    ->authorizeIndividualRecords('delete')
                    ->modalContentView('pages.roles.delete-bulk')
                    ->action(function (Collection $records): void {
                        $records->each(fn (Role $record): Model => DeleteRole::run($record));
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
            ->emptyStateIcon(Illustration::PadlockShield)
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
