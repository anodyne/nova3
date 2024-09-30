<?php

declare(strict_types=1);

namespace Nova\Announcements\Livewire;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Nova\Announcements\Actions\DeleteAnnouncement;
use Nova\Announcements\Models\Announcement;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Livewire\TableComponent;

class AnnouncementsList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Announcement::with('user')->unless(
                    Auth::user()->can('manage', Announcement::class),
                    fn (Builder $query): Builder => $query->published()
                )
            )
            ->recordUrl(fn (Announcement $record): string => route('admin.announcements.show', $record))
            ->columns([
                ViewColumn::make('title')
                    ->view('filament.tables.columns.announcement')
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query->searchFor($search))
                    ->sortable(),
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
                    ->visible(Auth::user()->can('manage', Announcement::class)),
                TextColumn::make('published_at')
                    ->dateTime(settings('general')->phpDateFormat())
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
                        DeleteAction::make()
                            ->authorize('delete')
                            ->modalContentView('pages.announcements.delete')
                            ->successNotificationTitle(fn (Announcement $record): string => $record->title.' announcement was deleted')
                            ->using(fn (Announcement $record): Model => DeleteAnnouncement::run($record)),
                    ])->authorize('delete')->divided(),
                ]),
            ])
            ->filters([
                TernaryFilter::make('published_at')
                    ->label('Published')
                    ->placeholder('All announcements')
                    ->trueLabel('Published announcements')
                    ->falseLabel('Upcoming announcements')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->published(),
                        false: fn (Builder $query): Builder => $query->notPublished(),
                        blank: fn (Builder $query): Builder => $query,
                    )
                    ->visible(Auth::user()->can('manage', Announcement::class)),
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
