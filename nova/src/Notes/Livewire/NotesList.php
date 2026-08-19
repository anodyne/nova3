<?php

declare(strict_types=1);

namespace Nova\Notes\Livewire;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ReplicateAction;
use Nova\Foundation\Icons\Illustration;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Notes\Actions\DeleteNote;
use Nova\Notes\Actions\DuplicateNote;
use Nova\Notes\Events\NoteDuplicated;
use Nova\Notes\Models\Builders\NoteBuilder;
use Nova\Notes\Models\Note;
use Nova\Users\Models\User;
use RalphJSmit\Filament\Activitylog\Filament\Actions\TimelineAction;
use RalphJSmit\Filament\Activitylog\Filament\Infolists\Components\Timeline;
use Spatie\Activitylog\Models\Activity;

class NotesList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Note::query()
                    ->select([
                        'id',
                        'title',
                        'updated_at',
                        'user_id',
                    ])
                    ->currentUser()
            )
            ->recordUrl(fn (Note $record): string => route('admin.notes.show', $record))
            ->defaultSort('updated_at', 'desc')
            ->columns([
                TextColumn::make('title')
                    ->titleColumn()
                    ->searchable(query: fn (NoteBuilder $query, string $search): NoteBuilder => $query->searchFor($search))
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Last modified')
                    ->since()
                    ->sortable(),
            ])
            ->recordActions([
                ActionGroup::make([
                    ActionGroup::make([
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Note $record): string => route('admin.notes.edit', $record)),
                        ReplicateAction::make()
                            ->authorize('duplicate')
                            ->modalContentView('pages.notes.duplicate')
                            ->action(function (Note $record): void {
                                $replica = DuplicateNote::run($record = Note::find($record->id));

                                NoteDuplicated::dispatch($replica, $record);
                            }),
                    ])->divided(),

                    ActionGroup::make([
                        TimelineAction::make()
                            ->modifyTimelineUsing(function (Timeline $timeline): void {
                                $timeline
                                    ->eventDescriptions([
                                        'duplicated' => function (Activity $activity): string {
                                            $causer = $activity->causer;
                                            $causerName = $causer instanceof User
                                                ? $causer->name
                                                : 'System';

                                            return __('activity.notes.duplicated', [
                                                'name' => $causerName,
                                                'replica' => Note::find($activity->getExtraProperty('replica'))?->title,
                                            ]);
                                        },
                                    ]);
                            }),
                    ])->divided(),

                    ActionGroup::make([
                        DeleteAction::make()
                            ->authorize('delete')
                            ->modalContentView('pages.notes.delete')
                            ->successNotificationTitle('Note was deleted')
                            ->using(fn (Note $record): Model => DeleteNote::run($record)),
                    ])->divided(),
                ]),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->authorizeIndividualRecords('delete')
                    ->modalContentView('pages.notes.delete-bulk')
                    ->action(function (Collection $records): void {
                        $records->each(fn (Note $record): Model => DeleteNote::run($record));
                    }),
            ])
            ->emptyStateIcon(Illustration::Notes)
            ->emptyStateHeading('No notes found')
            ->emptyStateDescription('Notes help keep your thoughts organized about your game, a story idea, or even as a scratchpad for your next story post.')
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add a note')
                    ->url(route('admin.notes.create')),
            ]);
    }
}
