<?php

declare(strict_types=1);

namespace Nova\Forms\Livewire;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Nova\Forms\Actions\DeleteFormSubmission;
use Nova\Forms\Enums\FormType;
use Nova\Forms\Models\FormSubmission;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Helpers\DateHelper;
use Nova\Foundation\Icons\Icon;
use Nova\Foundation\Livewire\TableComponent;

class FormSubmissionsList extends TableComponent
{
    public function table(Table $table): Table
    {
        /** @var User */
        $user = Auth::user();

        return $table
            ->query(
                FormSubmission::query()
                    ->select([
                        'created_at',
                        'form_id',
                        'id',
                        'owner_id',
                        'owner_type',
                    ])
                    ->whereRelation('form', 'type', '=', FormType::Basic)
                    ->unless($user->can('manage', new FormSubmission), fn (Builder $query): Builder => $query->ownerIsUser($user))
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
                    ->sortable()
                    ->visible($user->can('manage', FormSubmission::class)),
                TextColumn::make('created_at')
                    ->label('Submitted on')
                    ->dateTime()
                    ->formatStateUsing(fn (FormSubmission $record): ?string => filled($record->created_at) ? DateHelper::formatDate($record->created_at) : null)
                    ->toggleable()
                    ->sortable(),
            ])
            ->recordActions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make()
                            ->url(fn (FormSubmission $record): string => route('admin.form-submissions.show', $record)),
                    ])->divided(),

                    ActionGroup::make([
                        DeleteAction::make()
                            ->authorize('delete')
                            ->modalContentView('pages.form-submissions.delete')
                            ->action(function (FormSubmission $record): void {
                                DeleteFormSubmission::run($record);

                                Notification::make()->success()->title('Form submission was deleted');
                            }),
                    ])->divided(),
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
            ->emptyStateIcon(Icon::FileText)
            ->emptyStateHeading('No form submissions found');
    }
}
