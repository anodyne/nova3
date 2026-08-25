<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Anodyne\TablerIcons\Tabler;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Number;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ForceDeleteAction;
use Nova\Foundation\Filament\Actions\ForceDeleteBulkAction;
use Nova\Foundation\Filament\Actions\ReplicateAction;
use Nova\Foundation\Filament\Actions\RestoreAction;
use Nova\Foundation\Filament\Actions\RestoreBulkAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Icons\Illustration;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Roles\Models\Role;
use Nova\Stories\Actions\DeletePostType;
use Nova\Stories\Actions\DuplicatePostType;
use Nova\Stories\Actions\ForceDeletePostType;
use Nova\Stories\Actions\MovePostTypePosts;
use Nova\Stories\Actions\RestorePostType;
use Nova\Stories\Data\PostTypeData;
use Nova\Stories\Enums\PostTypeVisibility;
use Nova\Stories\Events\PostTypeDuplicated;
use Nova\Stories\Models\Builders\PostTypeBuilder;
use Nova\Stories\Models\PostType;
use RalphJSmit\Filament\Activitylog\Filament\Actions\TimelineAction;
use RalphJSmit\Filament\Activitylog\Filament\Infolists\Components\Timeline;

class PostTypesList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                PostType::query()
                    ->select([
                        'color',
                        'deleted_at',
                        'description',
                        'fields',
                        'icon',
                        'id',
                        'name',
                        'options',
                        'order_column',
                        'role_id',
                        'status',
                        'visibility',
                    ])
                    ->withCount('posts')
                    ->withTrashed()
            )
            ->recordUrl(fn (PostType $record): string => route('admin.post-types.show', $record))
            ->defaultSort('order_column', 'asc')
            ->reorderable('order_column')
            ->columns([
                ViewColumn::make('name')
                    ->view('filament.tables.columns.post-type')
                    ->searchable(
                        query: fn (PostTypeBuilder $query, string $search): PostTypeBuilder => $query->searchFor($search)
                    )
                    ->sortable(),
                TextColumn::make('role.display_name')
                    ->badge()
                    ->label('Required access role')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('published_posts_count')
                    ->counts('publishedPosts')
                    ->label('# of published posts')
                    ->formatStateUsing(fn (int $state): string => Number::format($state) ?: number_format($state))
                    ->alignCenter()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('posts_count')
                    ->counts('posts')
                    ->label('# of posts')
                    ->alignCenter()
                    ->formatStateUsing(fn (int $state): string => Number::format($state) ?: number_format($state))
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('includedInPostTracking')
                    ->label('Included in post tracking')
                    ->alignCenter()
                    ->trueIcon(Tabler::CircleCheck)
                    ->falseIcon(Tabler::CircleX)
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                IconColumn::make('notifiesUsers')
                    ->label('Sends published notifications')
                    ->alignCenter()
                    ->trueIcon(Tabler::CircleCheck)
                    ->falseIcon(Tabler::CircleX)
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (PostType $record): string => $record->trashed() ? 'danger' : $record->status->getColor())
                    ->formatStateUsing(fn (PostType $record): string => $record->trashed() ? 'Deleted' : $record->status->getLabel())
                    ->toggleable(),
            ])
            ->recordActions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make()
                            ->authorize('view')
                            ->url(fn (PostType $record): string => route('admin.post-types.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (PostType $record): string => route('admin.post-types.edit', $record)),
                    ])->divided(),

                    ActionGroup::make([
                        TimelineAction::make()
                            ->modifyTimelineUsing(function (Timeline $timeline): void {
                                $timeline
                                    ->attributeLabels([
                                        'role_id' => 'role',
                                    ])
                                    ->attributeValues([
                                        'role_id' => fn ($value) => is_int($value) || is_string($value)
                                            ? Role::find($value)?->display_name
                                            : null,
                                        'visibility' => fn ($value): string => match ($value) {
                                            'out-of-character' => 'Out of Character',
                                            default => 'In Character',
                                        },
                                    ]);
                            }),
                    ])->divided(),

                    ActionGroup::make([
                        ReplicateAction::make()
                            ->authorize('duplicate')
                            ->modalContentView('pages.post-types.duplicate')
                            ->schema([
                                TextInput::make('name')->label('Post type name'),
                            ])
                            ->action(function (PostType $record, array $data): void {
                                $postTypeData = PostTypeData::from([
                                    'name' => $name = data_get($data, 'name'),
                                    'key' => str($name)->slug(),
                                    'description' => $record->description,
                                    'status' => $record->status,
                                    'fields' => $record->fields,
                                    'options' => $record->options,
                                    'role_id' => $record->role_id,
                                    'visibility' => $record->visibility,
                                    'icon' => $record->icon?->value,
                                    'color' => $record->color,
                                ]);

                                $replica = DuplicatePostType::run($record, $postTypeData);

                                PostTypeDuplicated::dispatch($replica, $record);

                                Notification::make()->success()
                                    ->title("{$replica->name} post type has been created")
                                    ->send();
                            }),
                    ])->divided(),

                    ActionGroup::make([
                        RestoreAction::make()
                            ->authorize('restore')
                            ->modalContentView('pages.post-types.restore')
                            ->action(function (PostType $record): void {
                                RestorePostType::run($record);

                                Notification::make()->success()
                                    ->title($record->name.' was restored')
                                    ->send();
                            }),
                        DeleteAction::make()
                            ->authorize('delete')
                            ->modalContentView('pages.post-types.delete')
                            ->schema(function (PostType $record): ?array {
                                if ($record->posts_count === 0) {
                                    return null;
                                }

                                return [
                                    Select::make('new_post_type')
                                        ->placeholder('Do not move posts to a new post type')
                                        ->options(PostType::where('id', '!=', $record->id)->pluck('name', 'id')),
                                ];
                            })
                            ->action(function (PostType $record, array $data): void {
                                if ($newPostTypeId = data_get($data, 'new_post_type')) {
                                    $newPostType = is_int($newPostTypeId) || is_string($newPostTypeId)
                                        ? PostType::find($newPostTypeId)
                                        : null;

                                    MovePostTypePosts::run(
                                        $record,
                                        $newPostType
                                    );

                                    $record->refresh();
                                } else {
                                    $newPostType = null;
                                }

                                DeletePostType::run($record);

                                Notification::make()->success()
                                    ->title($record->name.' post type was deleted')
                                    ->when(
                                        $newPostType,
                                        fn (Notification $notification): Notification => $notification->body('All posts have been re-assigned to the '.$newPostType->name.' post type.')
                                    );
                            }),
                        ForceDeleteAction::make()
                            ->authorize('forceDelete')
                            ->modalContentView('pages.post-types.force-delete')
                            ->schema(function (PostType $record): ?array {
                                if ($record->posts_count === 0) {
                                    return null;
                                }

                                return [
                                    Select::make('new_post_type')
                                        ->placeholder('Do not move posts to a new post type')
                                        ->options(PostType::where('id', '!=', $record->id)->pluck('name', 'id')),
                                ];
                            })
                            ->action(function (PostType $record, array $data): void {
                                $newPostTypeId = data_get($data, 'new_post_type');
                                $newPostType = is_int($newPostTypeId) || is_string($newPostTypeId)
                                    ? PostType::find($newPostTypeId)
                                    : null;

                                MovePostTypePosts::run(
                                    $record,
                                    $newPostType
                                );

                                ForceDeletePostType::run($record);

                                Notification::make()->success()
                                    ->title($record->name.' post type was force deleted')
                                    ->when(
                                        isset($newPostType),
                                        fn (Notification $notification): Notification => $notification->body('All posts have been re-assigned to the '.$newPostType->name.' post type.')
                                    );
                            }),
                    ])->divided(),
                ]),
            ])
            ->groupedBulkActions([
                RestoreBulkAction::make()
                    ->authorize('restoreAny')
                    ->modalContentView('pages.post-types.restore-bulk')
                    ->action(function (Collection $records): void {
                        $ignoredRecords = 0;

                        $records = $records
                            ->filter(function (PostType $record) use (&$ignoredRecords): bool {
                                if (Gate::allows('restore', $record)) {
                                    return true;
                                }

                                $ignoredRecords += 1;

                                return false;
                            })
                            ->each(fn (PostType $record): Model => RestorePostType::run($record));

                        Notification::make()->success()
                            ->title(count($records).' '.trans_choice('post type was|post types were', count($records)).' restored')
                            ->when($ignoredRecords > 0, fn (Notification $notification): Notification => $notification->body(sprintf(
                                '%d %s ignored due to being ineligible for this action.',
                                $ignoredRecords,
                                trans_choice('record was|records were', $ignoredRecords)
                            )))
                            ->send();
                    }),
                DeleteBulkAction::make()
                    ->authorize('deleteAny')
                    ->modalContentView('pages.post-types.delete-bulk')
                    ->action(function (Collection $records): void {
                        $ignoredRecords = 0;

                        $records = $records
                            ->filter(function (PostType $record) use (&$ignoredRecords): bool {
                                if (Gate::allows('delete', $record)) {
                                    return true;
                                }

                                $ignoredRecords += 1;

                                return false;
                            })
                            ->each(fn (PostType $record): Model => DeletePostType::run($record));

                        Notification::make()->success()
                            ->title(count($records).' '.trans_choice('post type was|post types were', count($records)).' deleted')
                            ->when($ignoredRecords > 0, fn (Notification $notification): Notification => $notification->body(sprintf(
                                '%d %s ignored due to being ineligible for this action.',
                                $ignoredRecords,
                                trans_choice('record was|records were', $ignoredRecords)
                            )))
                            ->send();
                    }),
                ForceDeleteBulkAction::make()
                    ->authorize('deleteAny')
                    ->modalContentView('pages.post-types.force-delete-bulk')
                    ->action(function (Collection $records): void {
                        $ignoredRecords = 0;

                        $records = $records
                            ->filter(function (PostType $record) use (&$ignoredRecords): bool {
                                if (Gate::allows('forceDelete', $record)) {
                                    return true;
                                }

                                $ignoredRecords += 1;

                                return false;
                            })
                            ->each(fn (PostType $record): Model => ForceDeletePostType::run($record));

                        Notification::make()->success()
                            ->title(count($records).' '.trans_choice('character was|characters were', count($records)).' force deleted')
                            ->when($ignoredRecords > 0, fn (Notification $notification): Notification => $notification->body(sprintf(
                                '%d %s ignored due to being ineligible for this action.',
                                $ignoredRecords,
                                trans_choice('record was|records were', $ignoredRecords)
                            )))
                            ->send();
                    }),
            ])
            ->filters([
                TernaryFilter::make('requires_role')
                    ->label('Requires a role')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->whereHas('role'),
                        false: fn (Builder $query): Builder => $query->whereDoesntHave('role')
                    ),
                SelectFilter::make('roles')
                    ->relationship('role', 'display_name')
                    ->multiple()
                    ->label('Required role(s)'),
                TernaryFilter::make('has_posts')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->whereHas('publishedPosts'),
                        false: fn (Builder $query): Builder => $query->whereDoesntHave('publishedPosts')
                    ),
                SelectFilter::make('status')->options(BasicStatus::class),
                SelectFilter::make('visibility')->options(PostTypeVisibility::class),
                TrashedFilter::make()->label('Deleted post types'),
            ])
            ->columnManagerWidth(Width::Small)
            ->header(fn (): Factory|View|null => $this->isTableReordering() ? view('filament.tables.reordering-notice') : null)
            ->emptyStateIcon(Illustration::PenAndQuill)
            ->emptyStateHeading('No post types found')
            ->emptyStateDescription('Post types allow you to control the type of content users can create inside of stories.')
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add a post type')
                    ->url(route('admin.post-types.create')),
            ]);
    }
}
