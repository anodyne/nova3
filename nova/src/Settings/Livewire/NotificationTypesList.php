<?php

declare(strict_types=1);

namespace Nova\Settings\Livewire;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Nova\Foundation\Filament\Actions\Action;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Foundation\Models\NotificationType;
use Nova\Notes\Actions\DeleteNote;
use Nova\Stories\Models\Story;

class NotificationTypesList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(NotificationType::query())
            ->groups([
                Group::make('audience')->collapsible(),
            ])
            ->defaultGroup('audience')
            ->columns([
                TextColumn::make('name')
                    ->titleColumn()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('audience')
                    ->badge()
                    ->color(fn (Model $record): string => $record->audience->color())
                    ->toggleable(),
                IconColumn::make('mail')
                    ->label('Email')
                    ->alignCenter()
                    ->icon(fn (Model $record): string => $record->mail->icon())
                    ->color(fn (Model $record): string => $record->mail->color()),
                IconColumn::make('database')
                    ->label('In-app')
                    ->alignCenter()
                    ->icon(fn (Model $record): string => $record->database->icon())
                    ->color(fn (Model $record): string => $record->database->color()),
                IconColumn::make('discord')
                    ->alignCenter()
                    ->icon(fn (Model $record): string => $record->discord->icon())
                    ->color(fn (Model $record): string => $record->discord->color()),
            ])
            ->actions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make()
                            ->authorize('view')
                            ->label('View draft')
                            ->url(fn (Model $record): string => route('notes.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->label('Continue writing')
                            ->url(fn (Model $record): string => route('notes.edit', $record)),
                    ])->authorizeAny(['view', 'update'])->divided(),
                    ActionGroup::make([
                        DeleteAction::make()
                            ->label('Discard draft')
                            ->modalHeading('Delete note?')
                            ->modalDescription("Are you sure you want to delete this note? You won't be able to recover it.")
                            ->modalSubmitActionLabel('Delete')
                            ->successNotificationTitle('Note was deleted')
                            ->using(fn (Model $record): Model => DeleteNote::run($record)),
                    ])->authorize('delete')->divided(),
                ]),
            ])
            ->filters([
                SelectFilter::make('postType')->relationship('postType', 'name')->multiple(),
                SelectFilter::make('story')
                    ->relationship('story', 'title', fn (Builder $query) => $query->current())
                    ->multiple()
                    ->hidden(fn () => Story::current()->count() <= 1),
            ])
            ->heading('Notification settings')
            // ->description('Drafts are posts in progress that have not been published')
            ->headerActions([
                Action::make('find-settings')
                    ->label('Find a setting')
                    ->icon(iconName('search'))
                    ->color('gray')
                    ->action(fn (Component $livewire) => $livewire->dispatch('toggle-spotlight')),
            ])
            ->emptyStateIcon(iconName('write'))
            ->emptyStateHeading('No draft posts found')
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Start writing')
                    ->icon(iconName('write'))
                    ->url(route('posts.create')),
            ]);
    }
}
