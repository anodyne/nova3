<?php

declare(strict_types=1);

namespace Nova\PostTypes\Livewire;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Livewire\Component;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ReplicateAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\PostTypes\Actions\DeletePostType;
use Nova\PostTypes\Actions\DuplicatePostType;
use Nova\PostTypes\Enums\PostTypeStatus;
use Nova\PostTypes\Events\PostTypeDuplicated;
use Nova\PostTypes\Models\PostType;

class PostTypesList extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(PostType::query())
            ->defaultSort('order_column', 'asc')
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
                TextColumn::make('posts_count')
                    ->counts('posts')
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
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('notifiesUsers')
                    ->label('Sends published notifications')
                    ->alignCenter()
                    ->icons([
                        iconName('check') => fn ($state): bool => $state === true,
                    ])
                    ->color('success')
                    ->toggleable(isToggledHiddenByDefault: true),
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
                            ->modalHeading('Duplicate post type?')
                            ->modalSubheading(
                                fn (Model $record): string => "Are you sure you want to duplicate the {$record->name} post type?"
                            )
                            ->modalSubmitActionLabel('Duplicate')
                            ->action(function (Model $record): void {
                                $replica = DuplicatePostType::run($record);

                                dispatch(new PostTypeDuplicated($replica, $record));

                                Notification::make()->success()
                                    ->title("{$replica->name} post type has been created")
                                    ->send();
                            }),
                    ])->authorize('duplicate')->divided(),
                    ActionGroup::make([
                        DeleteAction::make()
                            ->close()
                            ->modalHeading('Delete post type?')
                            ->modalSubheading(
                                fn (Model $record): string => "Are you sure you want to delete the {$record->name} post type? You won't be able to recover it. Users will no longer be able to create story posts with this post type."
                            )
                            ->modalSubmitActionLabel('Delete')
                            ->successNotificationTitle('Post type was deleted')
                            ->using(fn (Model $record): Model => DeletePostType::run($record)),
                    ])->authorize('delete')->divided(),
                ]),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->authorize('deleteAny')
                    ->modalHeading(
                        fn (Collection $records): string => "Delete {$records->count()} selected ".str('post type')->plural($records->count()).'?'
                    )
                    ->modalSubheading(function (Collection $records): string {
                        $statement = ($records->count() === 1)
                            ? 'this 1 post type'
                            : "these {$records->count()} post types";

                        $notice = ($records->count() === 1) ? 'it' : 'them';

                        return "Are you sure you want to delete {$statement}? You won't be able to recover {$notice}. Users will no longer be able to create story posts with {$notice}.";
                    })
                    ->modalSubmitActionLabel('Delete')
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
                        true: fn (Builder $query): Builder => $query->whereHas('posts'),
                        false: fn (Builder $query): Builder => $query->whereDoesntHave('posts')
                    ),
                SelectFilter::make('status')->options(PostTypeStatus::class),
            ])
            ->heading('Post types')
            ->description('Control the content users can post into stories')
            ->headerActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add')
                    ->url(route('post-types.create')),
            ])
            ->header(fn () => $this->isTableReordering() ? view('filament.tables.reordering-notice') : null)
            ->reorderable('order_column')
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

    public function render()
    {
        return view('livewire.filament-table');
    }
}
