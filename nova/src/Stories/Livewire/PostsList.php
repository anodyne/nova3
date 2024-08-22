<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Stories\Actions\DeletePost;
use Nova\Stories\Models\Post;

class PostsList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(Post::with('characterAuthors', 'userAuthors'))
            ->groups([
                Group::make('status')
                    ->getTitleFromRecordUsing(fn (Model $record): string => $record->status->displayName())
                    ->collapsible(),
                Group::make('story_id')
                    ->label('Story')
                    ->getTitleFromRecordUsing(fn (Model $record): string => $record->story->title)
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
                    ->getStateUsing(fn (Model $record): string => $record->timeline)
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
                    ->color(fn (Model $record): string => $record->status->color())
                    ->formatStateUsing(fn (Model $record): string => $record->status->displayName())
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
            ->actions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make()
                            ->authorize('view')
                            ->url(fn (Model $record): string => route('admin.posts.show', ['story' => $record->story, 'post' => $record])),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Model $record): string => route('admin.posts.edit', $record)),
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
                    ->multiple()
                    ->preload(),
                SelectFilter::make('story')
                    ->relationship('story', 'title')
                    ->multiple()
                    ->preload(),
                SelectFilter::make('status')
                    ->multiple()
                    ->options(fn (): array => Post::getStatesFor('status')->flatMap(fn ($state) => [$state => ucfirst($state)])->all()),
                TernaryFilter::make('published')
                    ->nullable()
                    ->attribute('published_at'),
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
