<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Posts\Actions\DeletePost;
use Nova\Posts\Models\Post;
use Nova\Stories\Models\Story;

class PostsList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Post::with('postType', 'story')
                    ->when(request()->route('story'), fn (Builder $query, Story $story): Builder => $query->story($story))
                    ->when(request()->route('story'), fn (Builder $query): Builder => $query->published())
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
            ->actions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make()
                            ->authorize('view')
                            ->url(fn (Model $record): string => route('posts.show', [$record->story, $record])),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Model $record): string => route('posts.edit', $record)),
                    ])->authorizeAny(['view', 'update'])->divided(),

                    ActionGroup::make([
                        DeleteAction::make()
                            ->modalContentView('pages.posts.delete')
                            ->successNotificationTitle(fn (Model $record): string => $record->title.' post was deleted')
                            ->using(fn (Model $record): Model => DeletePost::run($record)),
                    ])->authorize('delete')->divided(),
                ]),
            ])
            ->filters([
                SelectFilter::make('postType')
                    ->relationship('postType', 'name')
                    ->multiple(),
                SelectFilter::make('story')
                    ->relationship('story', 'title')
                    ->multiple()
                    ->visible(request()->route('story') === null),
            ])
            ->emptyStateIcon(iconName('write'))
            ->emptyStateHeading('No posts found');
    }
}
