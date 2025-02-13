<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Stories\Models\Post;

class RecentPublishedPostsList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Post::query()
                    ->with('postType', 'story')
                    ->select([
                        'day',
                        'id',
                        'location',
                        'post_type_id',
                        'published_at',
                        'story_id',
                        'time',
                        'title',
                        'locked_by',
                        'locked_at',
                    ])
                    ->published()
                    ->where('published_at', '>=', now()->subMonth())
            )
            ->defaultSort('published_at', 'desc')
            ->columns([
                ViewColumn::make('title')
                    ->view('filament.tables.columns.post-title')
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query->searchFor($search))
                    ->sortable(),
                TextColumn::make('postType.name')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('story.title')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('location')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('day')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('time')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('timeline')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('characterAuthors.name')
                    ->listWithLineBreaks()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('userAuthors.name')
                    ->listWithLineBreaks()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('published_at')
                    ->since()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('postType')->relationship('postType', 'name')->multiple(),
                SelectFilter::make('story')
                    ->relationship('story', 'title', fn (Builder $query) => $query->current())
                    ->multiple(),
            ])
            ->emptyStateIcon(iconName('write'))
            ->emptyStateHeading('No published posts found');
    }
}
