<?php

declare(strict_types=1);

namespace Nova\PostTypes\Livewire;

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
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ReplicateAction;
use Nova\Foundation\Filament\Actions\RestoreAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Livewire\TableComponent;
use Nova\PostTypes\Actions\DeletePostType;
use Nova\PostTypes\Actions\DuplicatePostType;
use Nova\PostTypes\Actions\RestorePostType;
use Nova\PostTypes\Data\PostTypeData;
use Nova\PostTypes\Enums\PostTypeStatus;
use Nova\PostTypes\Events\PostTypeDuplicated;
use Nova\PostTypes\Events\PostTypeRestored;
use Nova\PostTypes\Models\PostType;

class PostTypesList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(PostType::query()->withTrashed())
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
                    ->label('# of posts')
                    ->alignCenter()
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('includedInPostTracking')
                    ->label('Included in post tracking')
                    ->alignCenter()
                    ->icons([
                        iconName('check') => fn ($state): bool => $state === true,
                    ])
                    ->color('success')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                IconColumn::make('notifiesUsers')
                    ->label('Sends published notifications')
                    ->alignCenter()
                    ->icons([
                        iconName('check') => fn ($state): bool => $state === true,
                    ])
                    ->color('success')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (Model $record): string => $record->status->color())
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
                        DeleteAction::make()
                            ->authorize('delete')
                            ->modalContentView('pages.post-types.delete')
                            ->successNotificationTitle(fn (Model $record): string => $record->name.' post type was deleted')
                            ->using(fn (Model $record): Model => DeletePostType::run($record)),
                        RestoreAction::make()
                            ->authorize('restore')
                            ->modalContentView('pages.post-types.restore')
                            ->action(function (Model $record): void {
                                $postType = RestorePostType::run($record);

                                PostTypeRestored::dispatch($postType);

                                Notification::make()->success()
                                    ->title($record->name.' was restored')
                                    ->send();
                            }),
                    ])->authorizeAny(['delete', 'restore'])->divided(),
                ]),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->authorize('deleteAny')
                    ->modalContentView('pages.post-types.delete-bulk')
                    ->successNotificationTitle('Post types were deleted')
                    ->using(fn (Collection $records): Collection => $records->each(
                        fn (Model $record): Model => DeletePostType::run($record)
                    )),
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
            ->heading('Post types')
            ->description('Control the content users can post into stories')
            ->headerActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add')
                    ->url(route('post-types.create')),
            ])
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
