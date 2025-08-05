<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Nova\Foundation\Filament\Actions\Action;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Foundation\Icons\Icon;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Stories\Actions\DeletePost;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\Story;
use RalphJSmit\Filament\Activitylog\Filament\Actions\TimelineAction;

class StoryPostsList extends TableComponent
{
    public bool $simple = true;

    public bool $rounded = true;

    public ?Story $story = null;

    public function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->query(
                Post::query()
                    ->with('characterAuthors', 'userAuthors')
                    ->select([
                        'day',
                        'id',
                        'location',
                        'order_column',
                        'post_type_id',
                        'story_id',
                        'time',
                        'title',
                        'updated_at',
                        'locked_by',
                        'locked_at',
                        'status',
                    ])
                    ->story($this->story)
                    ->published()
            )
            ->defaultSort('order_column', 'desc')
            ->paginationPageOptions([10, 25, 50])
            ->defaultPaginationPageOption(25)
            ->columns([
                ViewColumn::make('title')
                    ->view('filament.tables.columns.post-title')
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query->searchFor($search))
                    ->sortable(),
                TextColumn::make('postType.name')
                    ->wrap()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('story.title')
                    ->wrap()
                    ->sortable()
                    ->toggleable()
                    ->visible(request()->route('story') === null),
                TextColumn::make('location')
                    ->wrap()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('day')
                    ->wrap()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('time')
                    ->wrap()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('characterAuthors.name')
                    ->listWithLineBreaks()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('userAuthors.name')
                    ->listWithLineBreaks()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
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
                            ->url(fn (Post $record): string => route('admin.posts.show', [$record->story, $record])),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Post $record): string => route('admin.posts.edit', $record)),
                    ])->divided(),

                    ActionGroup::make([
                        TimelineAction::make(),
                    ])->divided(),

                    ActionGroup::make([
                        Action::make('create-before')
                            ->icon(Icon::MoveUp)
                            ->color('gray')
                            ->label('Before this post')
                            ->url(fn (Post $record): string => route('admin.posts.create', ['neighbor' => $record, 'direction' => 'before'])),
                        Action::make('create-after')
                            ->icon(Icon::MoveDown)
                            ->color('gray')
                            ->label('After this post')
                            ->url(fn (Post $record): string => route('admin.posts.create', ['neighbor' => $record, 'direction' => 'after'])),
                    ])
                        ->divided()
                        ->visible(fn (Post $record): bool => $record->story->can_post),

                    ActionGroup::make([
                        DeleteAction::make()
                            ->modalContentView('pages.posts.delete')
                            ->successNotificationTitle(fn (Post $record): string => $record->title.' post was deleted')
                            ->using(fn (Post $record): Model => DeletePost::run($record)),
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
                    ->preload()
                    ->visible(request()->route('story') === null),
            ])
            ->emptyStateIcon(Icon::Write)
            ->emptyStateHeading('No posts found');
    }
}
