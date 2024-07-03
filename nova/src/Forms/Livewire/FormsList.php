<?php

declare(strict_types=1);

namespace Nova\Forms\Livewire;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Nova\Forms\Actions\DeleteFormManager;
use Nova\Forms\Enums\FormStatus;
use Nova\Forms\Enums\FormType;
use Nova\Forms\Models\Form;
use Nova\Foundation\Filament\Actions\Action;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
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
                    ->icon(fn (Form $record): ?string => $record->is_locked ? iconName('lock-closed') : null)
                    ->iconPosition('after')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->badge()
                    ->color(fn (Form $record): string => $record->type->color())
                    ->toggleable(),
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
                    ])->authorizeAny(['view', 'update'])->divided(),

                    ActionGroup::make([
                        Action::make('design')
                            ->authorize('design')
                            ->icon(iconName('tools'))
                            ->url(fn (Form $record): string => route('forms.design', $record)),
                        Action::make('preview')
                            ->icon(iconName('form-preview'))
                            ->label('Preview form')
                            ->url(fn (Form $record): string => route('forms.preview', $record)),
                    ])->authorize('design')->divided(),

                    ActionGroup::make([
                        Action::make('submissions')
                            ->icon(iconName('clipboard'))
                            ->url(fn (Form $record): string => route('form-submissions.index'))
                            ->visible(fn (Form $record): bool => $record->options?->collectResponses ?? false),
                    ])->divided(),

                    ActionGroup::make([
                        DeleteAction::make()
                            ->authorize('delete')
                            ->modalContentView('pages.forms.delete')
                            ->action(function (Form $record): void {
                                DeleteFormManager::run($record);

                                Notification::make()->success()->title($record->name.' form was deleted');
                            }),
                    ])->authorize('delete')->divided(),
                ]),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->authorize('deleteAny')
                    ->modalContentView('pages.forms.delete-bulk')
                    ->action(function (Collection $records): void {
                        $ignoredRecords = 0;

                        $records = $records
                            ->filter(function (Model $record) use (&$ignoredRecords): bool {
                                if (Gate::allows('delete', $record)) {
                                    return true;
                                }

                                $ignoredRecords += 1;

                                return false;
                            })
                            ->each(fn (Model $record): Model => DeleteFormManager::run($record));

                        Notification::make()->success()
                            ->title(count($records).' '.trans_choice('form was|forms were', count($records)).' deleted')
                            ->when($ignoredRecords > 0, function (Notification $notification) use ($ignoredRecords) {
                                return $notification->body(sprintf(
                                    '%d %s ignored due to being ineligible for this action.',
                                    $ignoredRecords,
                                    trans_choice('record was|records were', $ignoredRecords)
                                ));
                            })
                            ->send();
                    }),
            ])
            ->filters([
                SelectFilter::make('type')->options(FormType::class),
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
