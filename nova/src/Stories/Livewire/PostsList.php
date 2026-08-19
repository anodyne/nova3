<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Anodyne\TablerIcons\Tabler;
use Filament\Actions\Action;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Stories\Actions\ApprovePost;
use Nova\Stories\Actions\DeletePost;
use Nova\Stories\Actions\DiscardPost;
use Nova\Stories\Actions\ForceUnlockPost;
use Nova\Stories\Models\Builders\PostBuilder;
use Nova\Stories\Models\Post;
use RalphJSmit\Filament\Activitylog\Filament\Actions\TimelineAction;
use RalphJSmit\Filament\Activitylog\Filament\Infolists\Components\Timeline;

class PostsList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Post::query()
                    ->with(['characterAuthors', 'userAuthors', 'participatingUsers'])
                    ->select([
                        'day',
                        'deleted_at',
                        'id',
                        'location',
                        'locked_at',
                        'locked_by',
                        'post_type_id',
                        'published_at',
                        'status',
                        'story_id',
                        'time',
                        'title',
                        'updated_at',
                    ])
            )
            ->groups([
                Group::make('status')
                    ->getTitleFromRecordUsing(fn (Post $record): string => $record->status->getLabel())
                    ->collapsible(),
                Group::make('story_id')
                    ->label('Story')
                    ->getTitleFromRecordUsing(fn (Post $record): string => $record->story->title)
                    ->collapsible(),
            ])
            ->defaultSort('published_at', 'desc')
            ->defaultGroup('status')
            ->paginationPageOptions([10, 25, 50])
            ->defaultPaginationPageOption(25)
            ->columns([
                ViewColumn::make('title')
                    ->view('filament.tables.columns.post-title')
                    ->searchable(query: fn (PostBuilder $query, string $search): PostBuilder => $query->searchFor($search))
                    ->sortable(),
                TextColumn::make('postType.name')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('story.title')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('location')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('timeline')
                    ->getStateUsing(fn (Post $record): string => $record->timeline)
                    ->toggleable(),
                TextColumn::make('day')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('time')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('characterAuthors.name')
                    ->listWithLineBreaks()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('userAuthors.name')
                    ->listWithLineBreaks()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('status')
                    ->badge()
                    ->toggleable(),
                TextColumn::make('published_at')
                    ->label('Published')
                    ->since()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->label('Last modified')
                    ->since()
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
            ])
            ->recordActions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make()
                            ->authorize('view')
                            ->url(fn (Post $record): string => route('admin.posts.show', ['story' => $record->story, 'post' => $record])),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Post $record): string => route('admin.posts.edit', $record)),
                        Action::make('approve')
                            ->authorize('approve')
                            ->icon(Tabler::CircleCheck)
                            ->modalContent(fn (Post $record, Action $action): View => view('pages.posts.approve', [
                                'record' => $record,
                                'action' => $action,
                            ]))
                            ->modalHeading('')
                            ->modalWidth(Width::Large)
                            ->modalSubmitActionLabel('Yes, approve it')
                            ->action(function (Post $record): void {
                                ApprovePost::run($record);

                                Notification::make()->success()
                                    ->title($record->title.' has been approved')
                                    ->body('The post has been published and notifications have been sent.')
                                    ->send();
                            }),
                    ])->divided(),

                    ActionGroup::make([
                        TimelineAction::make()
                            ->modifyTimelineUsing(function (Timeline $timeline): void {
                                $timeline
                                    ->itemIcon('locked', Tabler::Lock->value)
                                    ->itemIcon('unlocked', Tabler::LockOpen->value)
                                    ->itemIcon('published', Tabler::CircleCheck->value)
                                    ->itemIconColor('published', 'primary');
                            }),
                    ])->divided(),

                    ActionGroup::make([
                        Action::make('unlock')
                            ->authorize('update')
                            ->icon(Tabler::LockOpen)
                            ->label('Release lock')
                            ->successNotificationTitle(fn (Post $record): string => $record->title.' post has been unlocked')
                            ->action(fn (Post $record): mixed => ForceUnlockPost::run($record))
                            ->visible(fn (Post $record): bool => $record->isLocked()),
                    ])->divided(),

                    ActionGroup::make([
                        DeleteAction::make()
                            ->authorize('delete')
                            ->modalContentView('pages.posts.delete')
                            ->successNotificationTitle(fn (Post $record): string => $record->title.' post was deleted')
                            ->using(fn (Post $record): Model => DeletePost::run($record)),

                        DeleteAction::make('discard')
                            ->authorize('discard')
                            ->label('Discard')
                            ->icon(Tabler::TrashX)
                            ->modalContentView('pages.posts.discard')
                            ->successNotificationTitle(fn (Post $record): string => $record->title.' post was discarded')
                            ->using(fn (Post $record): Model => DiscardPost::run($record)),
                    ])->divided(),
                ]),
            ])
            ->filters([
                SelectFilter::make('postType')
                    ->relationship('postType', 'name')
                    ->multiple()
                    ->preload(),
                SelectFilter::make('story')
                    ->relationship('story', 'title')
                    ->multiple()
                    ->preload(),
                SelectFilter::make('status')
                    ->multiple()
                    ->options(fn (): array => Post::getStatesFor('status')->flatMap(fn ($state): array => [$state => ucfirst($state)])->all())
                    ->default(fn () => request()->query('status', [])),
                TernaryFilter::make('published')
                    ->nullable()
                    ->attribute('published_at'),
                TernaryFilter::make('locked')
                    ->label('Lock status')
                    ->trueLabel('Locked')
                    ->falseLabel('Unlocked')
                    ->queries(
                        true: fn (PostBuilder $query): PostBuilder => $query->locked(),
                        false: fn (PostBuilder $query): PostBuilder => $query->unlocked(),
                        blank: fn (PostBuilder $query): PostBuilder => $query
                    ),
            ])
            ->emptyStateIcon(Tabler::Edit)
            ->emptyStateHeading('No story posts found')
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Start writing')
                    ->icon(Tabler::Edit)
                    ->url(route('admin.posts.create')),
            ]);
    }
}
