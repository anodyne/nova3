<?php

declare(strict_types=1);

namespace Nova\Dashboards\Livewire;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Notes\Actions\DeleteNote;
use Nova\Posts\Models\Post;
use Nova\Stories\Models\Story;

class MyDraftsList extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Post::with('postType', 'story')
                    ->whereDraft()
                    ->whereHas('story', fn (Builder $query): Builder => $query->current())
                    ->whereHas('participatingUsers', fn (Builder $query): Builder => $query->where('post_author.user_id', auth()->id()))
            )
            ->columns([
                ViewColumn::make('title')
                    ->view('filament.tables.columns.post-title')
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query->searchFor($search))
                    ->sortable(),
                TextColumn::make('postType.name')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('story.title')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('location')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('day')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('time')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('characterAuthors.name')
                    ->listWithLineBreaks()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('userAuthors.name')
                    ->listWithLineBreaks()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Last modified')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                            ->modalSubheading("Are you sure you want to delete this note? You won't be able to recover it.")
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
            ->heading('My draft posts')
            ->description('Drafts are posts in progress that have not been published')
            ->headerActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Start writing')
                    ->icon(iconName('write'))
                    ->url(route('posts.create')),
            ])
            ->emptyStateIcon(iconName('write'))
            ->emptyStateHeading('No draft posts found')
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Start writing')
                    ->url(route('posts.create')),
            ]);
    }

    public function render()
    {
        return view('livewire.filament-table');
    }
}
