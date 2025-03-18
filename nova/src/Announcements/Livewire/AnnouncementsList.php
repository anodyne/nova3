<?php

declare(strict_types=1);

namespace Nova\Announcements\Livewire;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Nova\Announcements\Actions\DeleteAnnouncement;
use Nova\Announcements\Models\Announcement;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Helpers\DateHelper;
use Nova\Foundation\Livewire\TableComponent;
use RalphJSmit\Filament\Activitylog\Infolists\Components\Timeline;
use RalphJSmit\Filament\Activitylog\Tables\Actions\TimelineAction;

class AnnouncementsList extends TableComponent
{
    public function table(Table $table): Table
    {
        /** @var User */
        $user = Auth::user();

        return $table
            ->query(
                Announcement::query()
                    ->with([
                        'user',
                        'notifications' => fn (HasMany $query): HasMany => $query->where('user_id', $user->id),
                    ])
                    ->select([
                        'id',
                        'user_id',
                        'title',
                        'category',
                        'published',
                        'published_at',
                    ])
                    ->unless(
                        $user->can('manage', Announcement::class),
                        fn (Builder $query): Builder => $query->published()
                    )
            )
            ->defaultSort('published_at', 'desc')
            ->recordUrl(fn (Announcement $record): string => route('admin.announcements.show', $record))
            ->columns([
                ViewColumn::make('title')
                    ->view('filament.tables.columns.announcement')
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query->searchFor($search))
                    ->sortable(),
                TextColumn::make('category')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('user.name')
                    ->label('Author')
                    ->toggleable(),
                IconColumn::make('published')
                    ->icon(fn (bool $state): string => match ($state) {
                        true => iconName('check'),
                        false => iconName('prohibited')
                    })
                    ->color(fn (bool $state): string => match ($state) {
                        true => 'success',
                        false => 'danger'
                    })
                    ->visible($user->can('manage', Announcement::class)),
                TextColumn::make('published_at')
                    ->dateTime()
                    ->formatStateUsing(fn (Announcement $record): ?string => filled($record->published_at) ? DateHelper::formatDate($record->published_at) : null)
                    ->sortable()
                    ->toggleable(),
            ])
            ->actions([
                ActionGroup::make([
                    ActionGroup::make([
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Announcement $record): string => route('admin.announcements.edit', $record)),
                    ])->authorize('update')->divided(),

                    ActionGroup::make([
                        TimelineAction::make()
                            ->modifyTimelineUsing(function (Timeline $timeline) {
                                $timeline
                                    ->attributeValues([
                                        'published_at' => fn ($value) => filled($value) ? DateHelper::formatDate($value) : null,
                                    ]);
                            }),
                    ])->divided(),

                    ActionGroup::make([
                        DeleteAction::make()
                            ->authorize('delete')
                            ->modalContentView('pages.announcements.delete')
                            ->successNotificationTitle(fn (Announcement $record): string => $record->title.' announcement was deleted')
                            ->using(fn (Announcement $record): Model => DeleteAnnouncement::run($record)),
                    ])->authorize('delete')->divided(),
                ]),
            ])
            ->filters([
                TernaryFilter::make('is_seen')
                    ->label('Unread')
                    ->placeholder('All announcements')
                    ->trueLabel('Only unread announcements')
                    ->falseLabel('Only read announcements')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->withUnreadNotificationsForUser($user),
                        false: fn (Builder $query): Builder => $query->withReadNotificationsForUser($user),
                        blank: fn (Builder $query): Builder => $query
                    ),
                TernaryFilter::make('published_at')
                    ->label('Published')
                    ->placeholder('All announcements')
                    ->trueLabel('Published announcements')
                    ->falseLabel('Upcoming announcements')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->published(),
                        false: fn (Builder $query): Builder => $query->notPublished(),
                        blank: fn (Builder $query): Builder => $query
                    )
                    ->visible($user->can('manage', Announcement::class)),
                SelectFilter::make('category')
                    ->options(Announcement::query()->uniqueCategories()->pluck('category', 'category')->all()),
            ])
            ->emptyStateIcon(iconName('megaphone'))
            ->emptyStateHeading('No announcements')
            ->emptyStateDescription(null)
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add an announcement')
                    ->url(route('admin.announcements.create')),
            ]);
    }
}
