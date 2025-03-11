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
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Nova\Foundation\Filament\Actions\Action;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Stories\Models\Post;

class DraftPostsList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Post::query()
                    ->with('postType', 'story', 'lockOwner')
                    ->select([
                        'day',
                        'id',
                        'last_update_by',
                        'location',
                        'locked_at',
                        'locked_by',
                        'post_type_id',
                        'published_at',
                        'story_id',
                        'time',
                        'title',
                    ])
                    ->draft()
                    ->whereHas('story', fn (Builder $query): Builder => $query->current())
                    ->whereHas(
                        'participatingUsers',
                        fn (Builder $query): Builder => $query->where('post_author.user_id', Auth::id())
                    )
            )
            ->defaultSort('updated_at', 'desc')
            ->recordUrl(fn (Post $record): ?string => route('admin.posts.edit', $record))
            ->columns([
                Split::make([
                    Stack::make([
                        ViewColumn::make('title')
                            ->view('filament.tables.columns.post-title', ['tight' => true, 'locked' => false]),
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
                    Stack::make([
                        TextColumn::make('needs_attention')
                            ->badge()
                            ->getStateUsing(fn (Post $record): ?string => $record->needs_attention ? 'Needs attention' : null)
                            ->color('warning')
                            ->alignEnd(),
                        TextColumn::make('locked_at')
                            ->badge()
                            ->getStateUsing(function (Post $record): ?string {
                                if ($record->isLocked()) {
                                    return str('Locked by ')
                                        ->append($record->lockIsOwnedBy(Auth::user()) ? 'you' : $record->lockOwner->name)
                                        ->toString();
                                }

                                return null;
                            })
                            ->color('gray')
                            ->icon(iconName('lock-closed'))
                            ->alignEnd(),
                    ])->extraAttributes(['class' => 'gap-y-1.5'])->grow(false),
                ]),
            ])
            ->emptyStateIcon(iconName('write'))
            ->emptyStateHeading('You don’t have any draft posts')
            ->emptyStateDescription('Start writing a post to join in on the fun.')
            ->emptyStateActions([
                Action::make('write')
                    ->url(route('admin.posts.create'))
                    ->label('Start writing')
                    ->icon(iconName('write'))
                    ->authorize('create'),
            ]);
    }
}
