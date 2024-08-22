<?php

declare(strict_types=1);

namespace Nova\Forms\Livewire;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Nova\Forms\Actions\DeleteFormSubmission;
use Nova\Forms\Models\FormSubmission;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Livewire\TableComponent;

class FormSubmissionsList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                FormSubmission::query()
                    ->whereHas('form', fn (Builder $query): Builder => $query->basic())
            )
            ->defaultSort('created_at', 'desc')
            ->groups([
                Group::make('form.name')->collapsible(),
            ])
            ->columns([
                TextColumn::make('titleField')
                    ->titleColumn()
                    ->label('Title'),
                TextColumn::make('form.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('owner.name')
                    ->label('Submitted by')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Submitted on')
                    ->dateTime(settings('general')->phpDateFormat())
                    ->toggleable()
                    ->sortable(),
            ])
            ->actions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make()
                            ->authorize('view')
                            ->url(fn (FormSubmission $record): string => route('admin.form-submissions.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (FormSubmission $record): string => route('admin.forms.edit', $record)),
                    ])->authorizeAny(['view', 'update'])->divided(),

                    ActionGroup::make([
                        DeleteAction::make()
                            ->authorize('delete')
                            ->modalContentView('pages.form-submissions.delete')
                            ->action(function (FormSubmission $record): void {
                                DeleteFormSubmission::run($record);

                                Notification::make()->success()->title('Form submission was deleted');
                            }),
                    ])->authorize('delete')->divided(),
                ]),
            ])
            ->filters([
                SelectFilter::make('form')
                    ->relationship(
                        name: 'form',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query): Builder => $query->basic()
                    ),
            ])
            ->defaultPaginationPageOption(25)
            ->emptyStateIcon(iconName('file-text'))
            ->emptyStateHeading('No form submissions found');
    }
}
