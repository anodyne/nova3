<?php

declare(strict_types=1);

namespace Nova\Stories\Livewire;

use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Foundation\Filament\Forms\Components\DatePicker;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Stories\Actions\UpdateStory;
use Nova\Stories\Actions\UpdateStoryStatus;
use Nova\Stories\Models\Story;

class StoriesList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(Story::query())
            ->groups([
                Group::make('status')
                    ->getTitleFromRecordUsing(fn (Model $record): string => $record->status->displayName())
                    ->collapsible(),
                Group::make('parent_id')
                    ->label('Parent story')
                    ->getTitleFromRecordUsing(fn (Model $record): string => $record->parent?->title ?? 'None')
                    ->collapsible(),
            ])
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
                    ->toggledHiddenByDefault(),
                TextColumn::make('posts_sum_word_count')
                    ->sum('posts', 'word_count')
                    ->label('# of words')
                    ->numeric()
                    ->alignCenter()
                    ->summarize([
                        Sum::make()->label('Total words'),
                        Average::make()
                            ->label('Avg words / story')
                            ->numeric(
                                decimalPlaces: 2
                            ),
                    ])
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('started_at')
                    ->wrap()
                    ->date(settings('general')->phpDateFormat())
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('ended_at')
                    ->wrap()
                    ->date(settings('general')->phpDateFormat())
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (Model $record): string => $record->status->color())
                    ->formatStateUsing(fn (Model $record): string => $record->status->displayName())
                    ->toggleable(),
            ])
            ->actions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make()
                            ->authorize('view')
                            ->url(fn (Model $record): string => route('stories.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Model $record): string => route('stories.edit', $record)),
                        Action::make('dates')
                            ->authorize('updateDates')
                            ->label('Update dates')
                            ->icon(iconName('calendar'))
                            ->color('gray')
                            ->fillForm(fn (Model $record): array => [
                                'start_date' => $record->started_at->toIso8601String(),
                                'end_date' => $record->ended_at->toIso8601String(),
                            ])
                            ->form([
                                DatePicker::make('start_date')->prefixIcon(iconName('calendar')),
                                DatePicker::make('end_date')->prefixIcon(iconName('calendar')),
                            ])
                            ->modalWidth('lg')
                            ->modalIcon(null)
                            ->modalHeading('')
                            ->modalDescription(null)
                            ->modalSubmitActionLabel('Update')
                            ->modalContent(fn (Model $record): View => view('pages.stories.edit-dates', [
                                'record' => $record,
                            ]))
                            ->action(function (Model $record, array $data): void {
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
                            Action::make('status_current')
                                ->close()
                                ->color('gray')
                                ->label('Mark as current')
                                ->hidden(fn (Model $record): bool => $record->is_current)
                                ->action(fn (Model $record): Model => UpdateStoryStatus::run($record, 'current')),
                            Action::make('status_ongoing')
                                ->close()
                                ->color('gray')
                                ->label('Mark as ongoing')
                                ->hidden(fn (Model $record): bool => $record->is_ongoing)
                                ->action(fn (Model $record): Model => UpdateStoryStatus::run($record, 'ongoing')),
                            Action::make('status_completed')
                                ->close()
                                ->color('gray')
                                ->label('Mark as completed')
                                ->hidden(fn (Model $record): bool => $record->is_completed)
                                ->action(fn (Model $record): Model => UpdateStoryStatus::run($record, 'completed')),
                            Action::make('status_upcoming')
                                ->close()
                                ->color('gray')
                                ->label('Mark as upcoming')
                                ->hidden(fn (Model $record): bool => $record->is_upcoming)
                                ->action(fn (Model $record): Model => UpdateStoryStatus::run($record, 'upcoming')),
                        ])
                            ->grouped()
                            ->icon(iconName('change'))
                            ->label('Change status'),
                    ])->authorizeAny(['view', 'update', 'updateDates'])->divided(),

                    ActionGroup::make([
                        Action::make('create-before')
                            ->icon(iconName('move-up'))
                            ->color('gray')
                            ->label('Before this story')
                            ->url(fn (Model $record): string => route('stories.create', 'direction=before&neighbor='.$record->id)),
                        Action::make('create-after')
                            ->icon(iconName('move-down'))
                            ->color('gray')
                            ->label('After this story')
                            ->url(fn (Model $record): string => route('stories.create', 'direction=after&neighbor='.$record->id)),
                        Action::make('create-inside')
                            ->icon(iconName('move-right'))
                            ->color('gray')
                            ->label('Inside this story')
                            ->url(fn (Model $record): string => route('stories.create', 'parent='.$record->id)),
                    ])->authorize('create')->divided(),

                    ActionGroup::make([
                        Action::make('delete')
                            ->icon(iconName('trash'))
                            ->color('danger')
                            ->url(fn (Model $record): string => route('stories.delete', $record)),
                    ])->authorize('delete')->divided(),
                ]),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->multiple()
                    ->options(fn (): array => Story::getStatesFor('status')->flatMap(fn ($state) => [$state => ucfirst($state)])->all()),
                SelectFilter::make('parent_id')
                    ->relationship('parentStory', 'title')
                    ->label('Parent story'),
                TernaryFilter::make('has_parent_story')
                    ->nullable()
                    ->attribute('parent_id'),
            ])
            ->heading('Stories')
            ->description('Manage the stories and timeline of your game')
            ->headerActions([
                Action::make('timeline')
                    ->icon(iconName('timeline'))
                    ->iconSize('md')
                    ->color('primary')
                    ->outlined()
                    ->label('Story timeline')
                    ->url(route('stories.timeline', 'stories')),
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add')
                    ->url(route('stories.create')),
            ])
            ->emptyStateIcon(iconName('book'))
            ->emptyStateHeading('No stories found')
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add your first story')
                    ->url(route('stories.create')),
            ]);
    }
}
