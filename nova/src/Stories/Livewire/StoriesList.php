<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Filament\Actions\Action;
use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Foundation\Filament\Forms\Components\DatePicker;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Helpers\DateHelper;
use Nova\Foundation\Icons\Icon;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Stories\Actions\UpdateStory;
use Nova\Stories\Actions\UpdateStoryStatus;
use Nova\Stories\Models\Story;
use RalphJSmit\Filament\Activitylog\Filament\Actions\TimelineAction;
use RalphJSmit\Filament\Activitylog\Filament\Infolists\Components\Timeline;
use Spatie\Activitylog\Models\Activity;

class StoriesList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Story::query()
                    ->with('parentStory')
                    ->select([
                        'description',
                        'ended_at',
                        'id',
                        'order_column',
                        'parent_id',
                        'started_at',
                        'status',
                        'title',
                    ])
            )
            ->defaultSort('order_column', 'asc')
            ->columns([
                TextColumn::make('title')
                    ->wrap()
                    ->titleColumn()
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query->searchFor($search))
                    ->sortable(),
                TextColumn::make('parentStory.title')
                    ->wrap()
                    ->label('Parent story')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('posts_count')
                    ->counts('posts')
                    ->label('# of posts')
                    ->alignCenter()
                    // ->summarize([
                    //     Sum::make()->label('Total posts'),
                    //     Average::make()->label('Avg posts / story'),
                    // ])
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('recursive_posts_count')
                    ->counts('recursivePosts')
                    ->label('# of posts (inclusive)')
                    ->alignCenter()
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->visible(app('nova.environment')->database->isMysql()),
                TextColumn::make('posts_sum_word_count')
                    ->sum('posts', 'word_count')
                    ->label('# of words')
                    ->numeric()
                    ->alignCenter()
                    // ->summarize([
                    //     Sum::make()->label('Total words'),
                    //     Average::make()
                    //         ->label('Avg words / story')
                    //         ->numeric(decimalPlaces: 2),
                    // ])
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('started_at')
                    ->wrap()
                    ->date()
                    ->formatStateUsing(fn (Story $record): ?string => filled($record->started_at) ? DateHelper::formatDate($record->started_at) : null)
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('ended_at')
                    ->wrap()
                    ->date()
                    ->formatStateUsing(fn (Story $record): ?string => filled($record->ended_at) ? DateHelper::formatDate($record->ended_at) : null)
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('status')
                    ->badge()
                    ->toggleable(),
            ])
            ->recordActions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make()
                            ->authorize('view')
                            ->url(fn (Story $record): string => route('admin.stories.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Story $record): string => route('admin.stories.edit', $record)),
                        Action::make('dates')
                            ->authorize('updateDates')
                            ->label('Update dates')
                            ->icon(Icon::Calendar)
                            ->color('gray')
                            ->fillForm(fn (Story $record): array => [
                                'start_date' => $record->started_at->toIso8601String(),
                                'end_date' => $record->ended_at->toIso8601String(),
                            ])
                            ->schema([
                                DatePicker::make('start_date')->prefixIcon(Icon::Calendar),
                                DatePicker::make('end_date')->prefixIcon(Icon::Calendar),
                            ])
                            ->modalWidth('lg')
                            ->modalIcon(null)
                            ->modalHeading('')
                            ->modalDescription(null)
                            ->modalSubmitActionLabel('Update')
                            ->modalContent(fn (Story $record, Action $action): View => view('pages.stories.edit-dates', [
                                'record' => $record,
                                'action' => $action,
                            ]))
                            ->action(function (Story $record, array $data): void {
                                $storyData = $record->getData();
                                $storyData->startedAt = data_get($data, 'start_date');
                                $storyData->endedAt = data_get($data, 'end_date');

                                UpdateStory::run($record, $storyData);

                                Notification::make()->success()
                                    ->title("{$record->title} story dates have been updated")
                                    ->body('Any future status updates to the story will change the dates you have set.')
                                    ->send();
                            }),
                        ActionGroup::make([
                            Action::make('statusCurrent')
                                ->authorize('update')
                                ->close()
                                ->color('gray')
                                ->label('Mark as current')
                                ->hidden(fn (Story $record): bool => $record->is_current)
                                ->action(function (Story $record): void {
                                    UpdateStoryStatus::run($record, 'current');

                                    Notification::make()->success()
                                        ->title("{$record->title} status has been updated")
                                        ->body('The story is now marked as current and can be posted into.')
                                        ->send();
                                }),
                            Action::make('statusOngoing')
                                ->authorize('update')
                                ->close()
                                ->color('gray')
                                ->label('Mark as ongoing')
                                ->hidden(fn (Story $record): bool => $record->is_ongoing)
                                ->action(function (Story $record): void {
                                    UpdateStoryStatus::run($record, 'ongoing');

                                    Notification::make()->success()
                                        ->title("{$record->title} status has been updated")
                                        ->body('The story is now marked as ongoing and can be used to contain other stories.')
                                        ->send();
                                }),
                            Action::make('statusCompleted')
                                ->authorize('update')
                                ->close()
                                ->color('gray')
                                ->label('Mark as completed')
                                ->hidden(fn (Story $record): bool => $record->is_completed)
                                ->action(function (Story $record): void {
                                    UpdateStoryStatus::run($record, 'completed');

                                    Notification::make()->success()
                                        ->title("{$record->title} status has been updated")
                                        ->body('The story is now marked as completed and cannot be posted into.')
                                        ->send();
                                }),
                            Action::make('statusUpcoming')
                                ->authorize('update')
                                ->close()
                                ->color('gray')
                                ->label('Mark as upcoming')
                                ->hidden(fn (Story $record): bool => $record->is_upcoming)
                                ->action(function (Story $record): void {
                                    UpdateStoryStatus::run($record, 'upcoming');

                                    Notification::make()->success()
                                        ->title("{$record->title} status has been updated")
                                        ->body('The story is now marked as upcoming.')
                                        ->send();
                                }),
                        ])
                            ->grouped()
                            ->icon(Icon::StatusChange)
                            ->label('Change status'),
                    ])->divided(),

                    ActionGroup::make([
                        Action::make('create-before')
                            ->authorize('create')
                            ->icon(Icon::MoveUp)
                            ->color('gray')
                            ->label('Before this story')
                            ->url(fn (Story $record): string => route('admin.stories.create', 'direction=before&neighbor='.$record->id)),
                        Action::make('create-after')
                            ->authorize('create')
                            ->icon(Icon::MoveDown)
                            ->color('gray')
                            ->label('After this story')
                            ->url(fn (Story $record): string => route('admin.stories.create', 'direction=after&neighbor='.$record->id)),
                        Action::make('create-inside')
                            ->authorize('create')
                            ->icon(Icon::MoveRight)
                            ->color('gray')
                            ->label('Inside this story')
                            ->url(fn (Story $record): string => route('admin.stories.create', 'parent='.$record->id)),
                    ])->divided(),

                    ActionGroup::make([
                        TimelineAction::make()
                            ->modifyTimelineUsing(function (Timeline $timeline) {
                                $timeline
                                    ->attributeLabels([
                                        'parent_id' => 'parent story',
                                    ])
                                    ->attributeValues([
                                        'ended_at' => fn ($value) => filled($value) ? DateHelper::formatDate($value) : null,
                                        'parent_id' => fn ($value) => Story::find($value)?->title,
                                        'started_at' => fn ($value) => filled($value) ? DateHelper::formatDate($value) : null,
                                        'status' => fn ($value) => $value?->name(),
                                    ])
                                    ->eventDescriptions([
                                        'uploaded-image' => fn (Activity $activity) => __('activity.stories.uploaded-image', [
                                            'name' => $activity->causer->name,
                                        ]),
                                    ]);
                            }),
                    ])->divided(),

                    ActionGroup::make([
                        Action::make('delete')
                            ->authorize('delete')
                            ->icon(Icon::Trash)
                            ->color('danger')
                            ->url(fn (Story $record): string => route('admin.stories.delete', $record)),
                    ])->divided(),
                ]),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->multiple()
                    ->preload()
                    ->options(fn (): array => Story::getStatesFor('status')->flatMap(fn ($state) => [$state => ucfirst($state)])->all())
                    ->default(['current', 'ongoing', 'upcoming']),
                SelectFilter::make('parent_id')
                    ->relationship('parentStory', 'title')
                    ->label('Parent story'),
                TernaryFilter::make('has_parent_story')
                    ->nullable()
                    ->attribute('parent_id'),
            ])
            ->emptyStateIcon(Icon::Books)
            ->emptyStateHeading('No stories found')
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add a story')
                    ->url(route('admin.stories.create')),
            ]);
    }
}
