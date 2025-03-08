<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
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
                        'locked_at',
                        'locked_by',
                    ])
                    ->published()
                    ->where('published_at', '>=', now()->subMonth())
            )
            ->defaultSort('published_at', 'desc')
            ->recordUrl(fn (Post $record): ?string => route('admin.posts.show', ['story' => $record->story_id, 'post' => $record->id]))
            ->columns([
                Stack::make([
                    Split::make([
                        ViewColumn::make('title')->view('filament.tables.columns.post-title', ['tight' => true]),
                        TextColumn::make('published_at')
                            ->since()
                            ->color('gray')
                            ->grow(false),
                    ]),
                    Split::make([
                        TextColumn::make('story.title')
                            ->color('gray')
                            ->weight(FontWeight::Medium)
                            ->grow(false),
                        TextColumn::make('locationDayTime')
                            ->size(TextColumnSize::Small)
                            ->color('gray')
                            ->extraAttributes(['class' => 'italic'])
                            ->grow(false),
                    ]),
                ]),
            ])
            ->emptyStateIcon(iconName('write'))
            ->emptyStateHeading('No published posts found');
    }
}
