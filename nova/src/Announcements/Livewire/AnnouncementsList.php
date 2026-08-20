<?php

declare(strict_types=1);

namespace Nova\Announcements\Livewire;

use Anodyne\TablerIcons\Tabler;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;
use Nova\Announcements\Actions\ApproveAnnouncement;
use Nova\Announcements\Actions\DeleteAnnouncement;
use Nova\Announcements\Models\Announcement;
use Nova\Announcements\Models\Builders\AnnouncementBuilder;
use Nova\Foundation\Enums\PublishStatus;
use Nova\Foundation\Filament\Actions\Action;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Helpers\DateHelper;
use Nova\Foundation\Icons\Illustration;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Users\Models\User;
use RalphJSmit\Filament\Activitylog\Filament\Actions\TimelineAction;
use RalphJSmit\Filament\Activitylog\Filament\Infolists\Components\Timeline;

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
                        'notifications' => function (Relation $query) use ($user): void {
                            $query->where('user_id', $user->id);
                        },
                    ])
                    ->select([
                        'id',
                        'user_id',
                        'title',
                        'category',
                        'status',
                        'published_at',
                    ])
                    ->when(
                        $user->can('manage', Announcement::class) && $user->can('approveAny', Announcement::class),
                        fn (AnnouncementBuilder $query): AnnouncementBuilder => $query,
                    )
                    ->when(
                        $user->can('manage', Announcement::class) && $user->cannot('approveAny', Announcement::class),
                        fn (AnnouncementBuilder $query): AnnouncementBuilder => $query->whereIn('status', [PublishStatus::Published, PublishStatus::Draft]),
                    )
                    ->when(
                        $user->cannot('manage', Announcement::class) && $user->cannot('approveAny', Announcement::class),
                        fn (AnnouncementBuilder $query): AnnouncementBuilder => $query->published(),
                    )
            )
            ->defaultGroup(fn (): ?string => $user->can('manage', Announcement::class) ? 'status' : null)
            ->defaultSort('published_at', 'desc')
            ->groups(['status'])
            ->groupingSettingsHidden($user->cannot('manage', Announcement::class))
            ->recordUrl(fn (Announcement $record): string => route('admin.announcements.show', $record))
            ->columns([
                ViewColumn::make('title')
                    ->view('filament.tables.columns.announcement')
                    ->searchable(query: fn (AnnouncementBuilder $query, string $search): AnnouncementBuilder => $query->searchFor($search))
                    ->sortable(),
                TextColumn::make('category')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('user.name')
                    ->label('Author')
                    ->toggleable(),
                TextColumn::make('published_at')
                    ->label('Published')
                    ->dateTime()
                    ->formatStateUsing(fn (Announcement $record): ?string => filled($record->published_at) ? DateHelper::formatDate($record->published_at) : null)
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('status')
                    ->badge()
                    ->visible($user->can('manage', Announcement::class)),
            ])
            ->recordActions([
                ActionGroup::make([
                    ActionGroup::make([
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Announcement $record): string => route('admin.announcements.edit', $record)),
                    ])->divided(),

                    ActionGroup::make([
                        Action::make('approve')
                            ->authorize('approve')
                            ->icon(Tabler::CircleCheck)
                            ->modalContent(fn (Announcement $record, Action $action): View => view('pages.announcements.approve', [
                                'record' => $record,
                                'action' => $action,
                            ]))
                            ->modalHeading('')
                            ->modalWidth(Width::Large)
                            ->modalSubmitActionLabel('Yes, approve it')
                            ->action(function (Announcement $record): void {
                                ApproveAnnouncement::run($record);

                                Notification::make()->success()
                                    ->title($record->title.' has been approved')
                                    ->body('The announcement has been published and notifications have been sent.')
                                    ->send();
                            }),
                    ])->divided(),

                    ActionGroup::make([
                        TimelineAction::make()
                            ->modifyTimelineUsing(function (Timeline $timeline): void {
                                $timeline
                                    ->attributeValues([
                                        'published_at' => fn ($value): ?string => filled($value) ? DateHelper::formatDate($value) : null,
                                    ]);
                            }),
                    ])->divided(),

                    ActionGroup::make([
                        DeleteAction::make()
                            ->authorize('delete')
                            ->modalContentView('pages.announcements.delete')
                            ->successNotificationTitle(fn (Announcement $record): string => $record->title.' announcement was deleted')
                            ->using(fn (Announcement $record): Model => DeleteAnnouncement::run($record)),
                    ])->divided(),
                ]),
            ])
            ->filters([
                TernaryFilter::make('is_seen')
                    ->label('Unread')
                    ->placeholder('All announcements')
                    ->trueLabel('Only unread announcements')
                    ->falseLabel('Only read announcements')
                    ->queries(
                        true: fn (AnnouncementBuilder $query): AnnouncementBuilder => $query->withUnreadNotificationsForUser($user),
                        false: fn (AnnouncementBuilder $query): AnnouncementBuilder => $query->withReadNotificationsForUser($user)
                    ),
                TernaryFilter::make('published_at')
                    ->label('Published')
                    ->placeholder('All announcements')
                    ->trueLabel('Published announcements')
                    ->falseLabel('Draft announcements')
                    ->queries(
                        true: fn (AnnouncementBuilder $query): AnnouncementBuilder => $query->published(),
                        false: fn (AnnouncementBuilder $query): AnnouncementBuilder => $query->draft()
                    )
                    ->visible($user->can('manage', Announcement::class)),
                SelectFilter::make('category')
                    ->options(Announcement::query()->uniqueCategories()->pluck('category', 'category')->all()),
            ])
            ->emptyStateIcon(Illustration::Megaphone)
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
