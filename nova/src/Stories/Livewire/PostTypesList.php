<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
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
use Nova\Foundation\Livewire\TableComponent;
use Nova\Stories\Actions\DeletePostType;
use Nova\Stories\Actions\DuplicatePostType;
use Nova\Stories\Actions\ForceDeletePostType;
use Nova\Stories\Actions\MovePostTypePosts;
use Nova\Stories\Actions\RestorePostType;
use Nova\Stories\Data\PostTypeData;
use Nova\Stories\Enums\PostTypeStatus;
use Nova\Stories\Events\PostTypeDuplicated;
use Nova\Stories\Models\PostType;

class PostTypesList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(PostType::withCount('posts')->withTrashed())
            ->defaultSort('order_column', 'asc')
            ->reorderable('order_column')
            ->columns([
                ViewColumn::make('name')
                    ->view('filament.tables.columns.post-type')
                    ->searchable(
                        query: fn (Builder $query, string $search): Builder => $query->searchFor($search)
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
                    ->alignCenter()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('posts_count')
                    ->counts('posts')
                    ->label('# of posts')
                    ->alignCenter()
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('includedInPostTracking')
                    ->label('Included in post tracking')
                    ->alignCenter()
                    ->trueColor('success')
                    ->trueIcon(iconName('check'))
                    ->falseIcon('')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                IconColumn::make('notifiesUsers')
                    ->label('Sends published notifications')
                    ->alignCenter()
                    ->trueColor('success')
                    ->trueIcon(iconName('check'))
                    ->falseIcon('')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (Model $record): string => $record->trashed() ? 'danger' : $record->status->color())
                    ->formatStateUsing(fn (Model $record): string => $record->trashed() ? 'Deleted' : $record->status->getLabel())
                    ->toggleable(),
            ])
            ->actions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make()
                            ->authorize('view')
                            ->url(fn (Model $record): string => route('post-types.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Model $record): string => route('post-types.edit', $record)),
                    ])->authorizeAny(['view', 'update'])->divided(),

                    ActionGroup::make([
                        ReplicateAction::make()
                            ->authorize('duplicate')
                            ->modalContentView('pages.post-types.duplicate')
                            ->form([
                                TextInput::make('name')->label('Post type name'),
                            ])
                            ->action(function (Model $record, array $data): void {
                                $postTypeData = PostTypeData::from([
                                    'name' => $name = data_get($data, 'name'),
                                    'key' => str($name)->slug(),
                                    'fields' => $record->fields,
                                    'options' => $record->options,
                                    'visibility' => $record->visibility,
                                ]);

                                $replica = DuplicatePostType::run($record, $postTypeData);

                                PostTypeDuplicated::dispatch($replica, $record);

                                Notification::make()->success()
                                    ->title("{$replica->name} post type has been created")
                                    ->send();
                            }),
                    ])->authorize('duplicate')->divided(),

                    ActionGroup::make([
                        RestoreAction::make()
                            ->authorize('restore')
                            ->modalContentView('pages.post-types.restore')
                            ->action(function (Model $record): void {
                                RestorePostType::run($record);

                                Notification::make()->success()
                                    ->title($record->name.' was restored')
                                    ->send();
                            }),
                        DeleteAction::make()
                            ->authorize('delete')
                            ->modalContentView('pages.post-types.delete')
                            ->form(function (Model $record): ?array {
                                if ($record->posts_count === 0) {
                                    return null;
                                }

                                return [
                                    Select::make('new_post_type')
                                        ->placeholder('Do not move posts to a new post type')
                                        ->options(PostType::where('id', '!=', $record->id)->pluck('name', 'id')),
                                ];
                            })
                            ->action(function (Model $record, array $data): void {
                                if ($newPostTypeId = data_get($data, 'new_post_type')) {
                                    MovePostTypePosts::run(
                                        $record,
                                        $newPostType = PostType::find($newPostTypeId)
                                    );

                                    $record->refresh();
                                }

                                DeletePostType::run($record);

                                Notification::make()->success()
                                    ->title($record->name.' post type was deleted')
                                    ->when(
                                        isset($newPostType),
                                        fn (Notification $notification) => $notification->body('All posts have been re-assigned to the '.$newPostType->name.' post type.')
                                    );
                            }),
                        ForceDeleteAction::make()
                            ->authorize('forceDelete')
                            ->modalContentView('pages.post-types.force-delete')
                            ->form(function (Model $record): ?array {
                                if ($record->posts_count === 0) {
                                    return null;
                                }

                                return [
                                    Select::make('new_post_type')
                                        ->placeholder('Do not move posts to a new post type')
                                        ->options(PostType::where('id', '!=', $record->id)->pluck('name', 'id')),
                                ];
                            })
                            ->action(function (Model $record, array $data): void {
                                $newPostTypeId = data_get($data, 'new_post_type');

                                MovePostTypePosts::run(
                                    $record,
                                    $newPostType = PostType::find($newPostTypeId)
                                );

                                ForceDeletePostType::run($record);

                                Notification::make()->success()
                                    ->title($record->name.' post type was force deleted')
                                    ->when(
                                        isset($newPostType),
                                        fn (Notification $notification) => $notification->body('All posts have been re-assigned to the '.$newPostType->name.' post type.')
                                    );
                            }),
                    ])->authorizeAny(['delete', 'restore', 'forceDelete'])->divided(),
                ]),
            ])
            ->groupedBulkActions([
                RestoreBulkAction::make()
                    ->authorize('restoreAny')
                    ->modalContentView('pages.post-types.restore-bulk')
                    ->action(function (Collection $records): void {
                        $ignoredRecords = 0;

                        $records = $records
                            ->filter(function (Model $record) use (&$ignoredRecords): bool {
                                if (Gate::allows('restore', $record)) {
                                    return true;
                                }

                                $ignoredRecords += 1;

                                return false;
                            })
                            ->each(fn (Model $record): Model => RestorePostType::run($record));

                        Notification::make()->success()
                            ->title(count($records).' '.trans_choice('post type was|post types were', count($records)).' restored')
                            ->when($ignoredRecords > 0, function (Notification $notification) use ($ignoredRecords) {
                                return $notification->body(sprintf(
                                    '%d %s ignored due to being ineligible for this action.',
                                    $ignoredRecords,
                                    trans_choice('record was|records were', $ignoredRecords)
                                ));
                            })
                            ->send();
                    }),
                DeleteBulkAction::make()
                    ->authorize('deleteAny')
                    ->modalContentView('pages.post-types.delete-bulk')
                    ->action(function (Collection $records): void {
                        $ignoredRecords = 0;

                        $records = $records
                            ->filter(function (Model $record) use (&$ignoredRecords): bool {
                                if (Gate::allows('delete', $record)) {
                                    return true;
                                }

                                $ignoredRecords += 1;

                                return false;
                            })
                            ->each(fn (Model $record): Model => DeletePostType::run($record));

                        Notification::make()->success()
                            ->title(count($records).' '.trans_choice('post type was|post types were', count($records)).' deleted')
                            ->when($ignoredRecords > 0, function (Notification $notification) use ($ignoredRecords) {
                                return $notification->body(sprintf(
                                    '%d %s ignored due to being ineligible for this action.',
                                    $ignoredRecords,
                                    trans_choice('record was|records were', $ignoredRecords)
                                ));
                            })
                            ->send();
                    }),
                ForceDeleteBulkAction::make()
                    ->authorize('deleteAny')
                    ->modalContentView('pages.post-types.force-delete-bulk')
                    ->action(function (Collection $records): void {
                        $ignoredRecords = 0;

                        $records = $records
                            ->filter(function (Model $record) use (&$ignoredRecords): bool {
                                if (Gate::allows('forceDelete', $record)) {
                                    return true;
                                }

                                $ignoredRecords += 1;

                                return false;
                            })
                            ->each(fn (Model $record): Model => ForceDeletePostType::run($record));

                        Notification::make()->success()
                            ->title(count($records).' '.trans_choice('character was|characters were', count($records)).' force deleted')
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
                SelectFilter::make('status')->options(PostTypeStatus::class),
                TrashedFilter::make()->label('Deleted post types'),
            ])
            ->columnToggleFormWidth('sm')
            ->header(fn () => $this->isTableReordering() ? view('filament.tables.reordering-notice') : null)
            ->emptyStateIcon(iconName('list'))
            ->emptyStateHeading('No post types found')
            ->emptyStateDescription('Post types allow you to control the type of content users can create inside of stories.')
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add a post type')
                    ->url(route('post-types.create')),
            ]);
    }
}
