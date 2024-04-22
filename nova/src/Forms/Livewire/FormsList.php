<?php

declare(strict_types=1);

namespace Nova\Forms\Livewire;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Nova\Forms\Actions\DeleteForm;
use Nova\Forms\Enums\FormStatus;
use Nova\Forms\Models\Form;
use Nova\Foundation\Filament\Actions\Action;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Livewire\TableComponent;

class FormsList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(Form::query())
            ->columns([
                TextColumn::make('name')
                    ->titleColumn()
                    ->label('Form name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (Form $record): string => $record->status->color())
                    ->toggleable(),
            ])
            ->actions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make()
                            ->authorize('view')
                            ->url(fn (Form $record): string => route('forms.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Form $record): string => route('forms.edit', $record)),
                        Action::make('design')
                            ->authorize('design')
                            ->icon(iconName('tools'))
                            ->url(fn (Form $record): string => route('forms.design', $record)),
                    ])->authorizeAny(['view', 'update', 'design'])->divided(),

                    ActionGroup::make([
                        DeleteAction::make()
                            ->authorize('delete')
                            ->modalContentView('pages.forms.delete')
                            ->action(function (Form $record): void {
                                DeleteForm::run($record);

                                Notification::make()->success()->title($record->name.' form was deleted');
                            }),
                    ])->authorize('delete')->divided(),
                ]),
            ])
            ->filters([
                SelectFilter::make('status')->options(FormStatus::class),
            ])
            ->emptyStateIcon(iconName('list'))
            ->emptyStateHeading('No forms found')
            ->emptyStateDescription('Manage all of Nova’s forms.')
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add a form')
                    ->url(route('forms.create')),
            ]);
    }
}
