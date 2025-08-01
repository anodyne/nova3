<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Filament\Actions\Action;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
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
use Nova\Stories\Actions\ForceUnlockPost;
use Nova\Stories\Models\Post;
use RalphJSmit\Filament\Activitylog\Infolists\Components\Timeline;
use RalphJSmit\Filament\Activitylog\Tables\Actions\TimelineAction;

class PostsList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Post::query()
                    ->with('characterAuthors', 'userAuthors')
                    ->select([
                        'day',
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
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query->searchFor($search))
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
                            ->icon(iconName('check-circle'))
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
                    ])->authorizeAny(['view', 'update', 'approve'])->divided(),

                    ActionGroup::make([
                        TimelineAction::make()
                            ->modifyTimelineUsing(function (Timeline $timeline) {
                                $timeline
                                    ->itemIcon('locked', iconName('lock-closed'))
                                    ->itemIcon('unlocked', iconName('lock-open'))
                                    ->itemIcon('published', iconName('check-circle'))
                                    ->itemIconColor('published', 'primary');
                            }),
                    ])->divided(),

                    ActionGroup::make([
                        Action::make('unlock')
                            ->icon(iconName('lock-open'))
                            ->label('Release lock')
                            ->successNotificationTitle(fn (Post $record): string => $record->title.' post has been unlocked')
                            ->action(fn (Post $record): mixed => ForceUnlockPost::run($record))
                            ->visible(fn (Post $record): bool => $record->isLocked()),
                    ])->authorize('unlock')->divided(),

                    ActionGroup::make([
                        DeleteAction::make()
                            ->modalContentView('pages.posts.delete')
                            ->successNotificationTitle(fn (Post $record): string => $record->title.' post was deleted')
                            ->using(fn (Post $record): Model => DeletePost::run($record)),
                    ])->authorize('delete')->divided(),
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
                    ->options(fn (): array => Post::getStatesFor('status')->flatMap(fn ($state) => [$state => ucfirst($state)])->all())
                    ->default(fn () => request()->query('status', [])),
                TernaryFilter::make('published')
                    ->nullable()
                    ->attribute('published_at'),
                TernaryFilter::make('locked')
                    ->label('Lock status')
                    ->trueLabel('Locked')
                    ->falseLabel('Unlocked')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->locked(),
                        false: fn (Builder $query): Builder => $query->unlocked(),
                        blank: fn (Builder $query): Builder => $query
                    ),
            ])
            ->emptyStateIcon(iconName('write'))
            ->emptyStateHeading('No story posts found')
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Start writing')
                    ->icon(iconName('write'))
                    ->url(route('admin.posts.create')),
            ]);
    }
}
