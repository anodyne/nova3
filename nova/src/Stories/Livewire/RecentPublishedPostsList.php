<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Nova\Foundation\Icons\Illustration;
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
                            ->size(TextSize::Small)
                            ->color('gray')
                            ->extraAttributes(['class' => 'italic'])
                            ->grow(false),
                    ]),
                ]),
            ])
            ->emptyStateIcon(Illustration::InkPenDrawing)
            ->emptyStateHeading('No published posts found')
            ->heading('Recently published posts')
            ->description('Posts that have been published in the last 30 days');
    }
}
