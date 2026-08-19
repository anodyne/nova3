<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Anodyne\TablerIcons\Tabler;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Helpers\DateHelper;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Stories\Actions\UpdateStory;
use Nova\Stories\Data\StoryData;
use Nova\Stories\Models\Builders\StoryBuilder;
use Nova\Stories\Models\Story;
use Nova\Users\Models\User;
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
                        'summary',
                        'started_at',
                        'status',
                        'title',
                    ])
            )
            ->recordUrl(fn (Story $record): string => route('admin.stories.show', $record))
            ->defaultSort('order_column', 'asc')
            ->groups([
                Group::make('status')->collapsible(),
            ])
            ->columns([
                TextColumn::make('title')
                    ->wrap()
                    ->titleColumn()
                    ->searchable(query: fn (StoryBuilder $query, string $search): StoryBuilder => $query->searchFor($search))
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
                    ->summarize([
                        Sum::make()->label('Total posts'),
                        Average::make()->label('Avg posts / story'),
                    ])
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
                    ->summarize([
                        Sum::make()->label('Total words'),
                        Average::make()
                            ->label('Avg words / story')
                            ->numeric(decimalPlaces: 2),
                    ])
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
                            ->icon(Tabler::Calendar)
                            ->color('gray')
                            ->fillForm(fn (Story $record): array => [
                                'start_date' => $record->started_at->toIso8601String(),
                                'end_date' => $record->ended_at->toIso8601String(),
                            ])
                            ->schema([
                                DatePicker::make('start_date')->native(false),
                                DatePicker::make('end_date')->native(false),
                            ])
                            ->modalWidth('lg')->modalIcon()
                            ->modalHeading('')->modalDescription()
                            ->modalSubmitActionLabel('Update')
                            ->modalContent(fn (Story $record, Action $action): View => view('pages.stories.edit-dates', [
                                'record' => $record,
                                'action' => $action,
                            ]))
                            ->action(function (Story $record, array $data): void {
                                $storyData = StoryData::from(
                                    $record->title,
                                    $record->description,
                                    data_get($data, 'start_date'),
                                    data_get($data, 'end_date'),
                                    $record->parent_id,
                                    $record->summary,
                                );

                                UpdateStory::run($record, $storyData);

                                Notification::make()->success()
                                    ->title("{$record->title} story dates have been updated")
                                    ->body('Any future status updates to the story will change the dates you have set.')
                                    ->send();
                            }),
                    ])->divided(),

                    ActionGroup::make([
                        Action::make('create-before')
                            ->authorize('create')
                            ->icon(Tabler::ArrowUpSquare)
                            ->color('gray')
                            ->label('Add before this story')
                            ->url(fn (Story $record): string => route('admin.stories.create', 'direction=before&neighbor='.$record->id)),
                        Action::make('create-after')
                            ->authorize('create')
                            ->icon(Tabler::ArrowDownSquare)
                            ->color('gray')
                            ->label('Add after this story')
                            ->url(fn (Story $record): string => route('admin.stories.create', 'direction=after&neighbor='.$record->id)),
                        Action::make('create-inside')
                            ->authorize('create')
                            ->icon(Tabler::ArrowRightSquare)
                            ->color('gray')
                            ->label('Add inside this story')
                            ->url(fn (Story $record): string => route('admin.stories.create', 'parent='.$record->id)),
                    ])->divided(),

                    ActionGroup::make([
                        TimelineAction::make()
                            ->modifyTimelineUsing(function (Timeline $timeline): void {
                                $timeline
                                    ->attributeLabels([
                                        'parent_id' => 'parent story',
                                    ])
                                    ->attributeValues([
                                        'ended_at' => fn ($value): ?string => filled($value) ? DateHelper::formatDate($value) : null,
                                        'parent_id' => fn ($value) => Story::find($value)?->title,
                                        'started_at' => fn ($value): ?string => filled($value) ? DateHelper::formatDate($value) : null,
                                        'status' => fn ($value) => $value?->name(),
                                    ])
                                    ->eventDescriptions([
                                        'uploaded-image' => function (Activity $activity): string {
                                            $causer = $activity->causer;
                                            $causerName = $causer instanceof User
                                                ? $causer->name
                                                : 'System';

                                            return __('activity.stories.uploaded-image', [
                                                'name' => $causerName,
                                            ]);
                                        },
                                    ]);
                            }),
                    ])->divided(),

                    ActionGroup::make([
                        Action::make('delete')
                            ->authorize('delete')
                            ->icon(Tabler::Trash)
                            ->color('danger')
                            ->url(fn (Story $record): string => route('admin.stories.delete', $record)),
                    ])->divided(),
                ]),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->multiple()
                    ->preload()
                    ->options(fn (): array => Story::getStatesFor('status')->flatMap(fn ($state): array => [$state => ucfirst($state)])->all())
                    ->default(['current', 'ongoing', 'upcoming']),
                SelectFilter::make('parent_id')
                    ->relationship('parentStory', 'title')
                    ->label('Parent story'),
                TernaryFilter::make('has_parent_story')
                    ->nullable()
                    ->attribute('parent_id'),
            ])
            ->emptyStateIcon(Tabler::Books)
            ->emptyStateHeading('No stories found')
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add a story')
                    ->url(route('admin.stories.create')),
            ]);
    }
}
