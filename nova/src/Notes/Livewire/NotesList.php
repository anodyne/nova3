<?php

declare(strict_types=1);

namespace Nova\Notes\Livewire;

use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ReplicateAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Notes\Actions\DeleteNote;
use Nova\Notes\Actions\DuplicateNote;
use Nova\Notes\Events\NoteDuplicated;
use Nova\Notes\Models\Note;

class NotesList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(Note::query()->currentUser())
            ->defaultSort('updated_at', 'desc')
            ->columns([
                TextColumn::make('title')
                    ->titleColumn()
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query->searchFor($search))
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Last modified')
                    ->since()
                    ->sortable(),
            ])
            ->actions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make()
                            ->authorize('view')
                            ->url(fn (Model $record): string => route('notes.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Model $record): string => route('notes.edit', $record)),
                    ])->authorizeAny(['view', 'update'])->divided(),
                    ActionGroup::make([
                        ReplicateAction::make()
                            ->modalContentView('pages.notes.duplicate')
                            ->action(function (Model $record): void {
                                $replica = DuplicateNote::run($record);

                                NoteDuplicated::dispatch($replica, $record);

                                Notification::make()->success()
                                    ->title("{$record->title} note was duplicated")
                                    ->send();
                            }),
                    ])->authorize('duplicate')->divided(),
                    ActionGroup::make([
                        DeleteAction::make()
                            ->modalContentView('pages.notes.delete')
                            ->successNotificationTitle('Note was deleted')
                            ->using(fn (Model $record): Model => DeleteNote::run($record)),
                    ])->authorize('delete')->divided(),
                ]),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->authorize('deleteAny')
                    ->modalHeading(
                        fn (Collection $records): string => "Delete {$records->count()} selected ".str('note')->plural($records->count()).'?'
                    )
                    ->modalDescription(function (Collection $records): string {
                        $statement = ($records->count() === 1)
                            ? 'this 1 note'
                            : "these {$records->count()} notes";

                        $notice = ($records->count() === 1) ? 'it' : 'them';

                        return "Are you sure you want to delete {$statement}? You won't be able to recover {$notice}.";
                    })
                    ->modalSubmitActionLabel('Delete')
                    ->successNotificationTitle('Notes were deleted')
                    ->using(fn (Collection $records): Collection => $records->each(
                        fn (Model $record): Model => DeleteNote::run($record)
                    )),
            ])
            ->heading('My notes')
            ->headerActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add')
                    ->url(route('notes.create')),
            ])
            ->emptyStateIcon(iconName('note'))
            ->emptyStateHeading('No notes found')
            ->emptyStateDescription('Notes help keep your thoughts organized about your game, a story idea, or even as a scratchpad for your next story post.')
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add a note')
                    ->url(route('notes.create')),
            ]);
    }
}
