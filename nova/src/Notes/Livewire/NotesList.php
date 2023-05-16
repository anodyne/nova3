<?php

declare(strict_types=1);

namespace Nova\Notes\Livewire;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Livewire\Component;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ReplicateAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Notes\Actions\DeleteNote;
use Nova\Notes\Actions\DuplicateNote;
use Nova\Notes\Events\NoteDuplicated;
use Nova\Notes\Models\Note;

class NotesList extends Component implements HasTable
{
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Note::query()->currentUser())
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
                    ViewAction::make()
                        ->authorize('view')
                        ->url(fn (Model $record) => route('notes.show', $record)),
                    EditAction::make()
                        ->authorize('update')
                        ->url(fn (Model $record) => route('notes.edit', $record)),
                    ReplicateAction::make()
                        ->authorize('duplicate')
                        ->close()
                        ->successNotificationTitle(fn (Model $record) => "{$record->title} was duplicated")
                        ->using(function (Model $record) {
                            $replica = DuplicateNote::run($record);

                            NoteDuplicated::dispatch($replica, $record);

                            return $replica;
                        }),
                    DeleteAction::make()
                        ->authorize('delete')
                        ->modalHeading('Delete note?')
                        ->modalSubheading("Are you sure you want to delete this note? You won't be able to recover it.")
                        ->modalSubmitActionLabel('Delete')
                        ->successNotificationTitle('Note was deleted')
                        ->using(fn (Model $record) => DeleteNote::run($record)),
                ]),
            ])
            ->bulkActions([
                DeleteBulkAction::make()
                    ->modalHeading(
                        fn (Collection $records) => "Delete {$records->count()} selected ".str('note')->plural($records->count()).'?'
                    )
                    ->modalSubheading(function (Collection $records) {
                        $statement = ($records->count() === 1)
                            ? 'this 1 note'
                            : "these {$records->count()} notes";

                        $notice = ($records->count() === 1) ? 'it' : 'them';

                        return "Are you sure you want to delete {$statement}? You won't be able to recover {$notice}.";
                    })
                    ->modalSubmitActionLabel('Delete')
                    ->successNotificationTitle('Notes were deleted')
                    ->using(fn (Collection $records) => $records->each(
                        fn (Model $record) => DeleteNote::run($record)
                    )),
            ])
            ->defaultSort('updated_at', 'desc')
            ->heading('My notes')
            ->headerActions([
                CreateAction::make()->label('Add')->url(route('notes.create')),
            ])
            ->emptyStateIcon(iconName('note'))
            ->emptyStateHeading('No notes found')
            ->emptyStateDescription("Notes help keep your thoughts organized about your game, a story idea, or even as a scratchpad for your next story post.")
            ->emptyStateActions([
                CreateAction::make()->label('Add a note')->url(route('notes.create')),
            ]);
    }

    public function render()
    {
        return view('livewire.filament-table');
    }
}
