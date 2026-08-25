<?php

declare(strict_types=1);

namespace Nova\Forms\Livewire;

use Anodyne\TablerIcons\Tabler;
use BackedEnum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Nova\Forms\Actions\DeleteFormManager;
use Nova\Forms\Enums\FormType;
use Nova\Forms\Models\Form;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Filament\Actions\Action;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Helpers\DateHelper;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Users\Models\User;
use RalphJSmit\Filament\Activitylog\Filament\Actions\TimelineAction;
use RalphJSmit\Filament\Activitylog\Filament\Infolists\Components\Timeline;
use Spatie\Activitylog\Models\Activity;

class FormsList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Form::query()
                    ->select([
                        'id',
                        'is_locked',
                        'name',
                        'published_at',
                        'status',
                        'type',
                    ])
            )
            ->columns([
                TextColumn::make('name')
                    ->titleColumn()
                    ->label('Form name')
                    ->icon(fn (Form $record): ?BackedEnum => $record->is_locked ? Tabler::Lock : null)
                    ->iconPosition('after')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->badge()
                    ->toggleable(),
                TextColumn::make('published_at')
                    ->label('Last published')
                    ->dateTime()
                    ->formatStateUsing(fn (Form $record): ?string => filled($record->published_at) ? DateHelper::formatDate($record->published_at) : null)
                    ->toggleable(),
                TextColumn::make('status')
                    ->badge()
                    ->toggleable(),
            ])
            ->recordActions([
                ActionGroup::make([
                    ActionGroup::make([
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Form $record): string => route('admin.forms.edit', $record)),
                    ])->divided(),

                    ActionGroup::make([
                        TimelineAction::make()
                            ->modifyTimelineUsing(function (Timeline $timeline): void {
                                $timeline
                                    ->attributeLabels([
                                        'is_locked' => 'locked',
                                    ])
                                    ->eventDescriptions([
                                        'duplicated' => function (Activity $activity): string {
                                            $replicaId = $activity->getExtraProperty('replica');

                                            return __('activity.forms.duplicated', [
                                                'name' => $activity->causer instanceof User ? $activity->causer->name : 'System',
                                                'replica' => is_int($replicaId) || is_string($replicaId)
                                                    ? Form::find($replicaId)?->name
                                                    : null,
                                            ]);
                                        },
                                    ])
                                    ->itemIconColors([
                                        'published' => 'success',
                                        'unpublished' => 'warning',
                                    ]);
                            }),
                    ])->divided(),

                    ActionGroup::make([
                        Action::make('design')
                            ->authorize('design')
                            ->icon(Tabler::Tools)
                            ->url(fn (Form $record): string => route('admin.forms.design', $record)),
                        Action::make('preview')
                            ->icon(Tabler::InputSearch)
                            ->label('Preview form')
                            ->url(fn (Form $record): string => route('admin.forms.preview', $record)),
                    ])->divided(),

                    ActionGroup::make([
                        Action::make('submissions')
                            ->icon(Tabler::Clipboard)
                            ->url(route('admin.form-submissions.index'))
                            ->visible(fn (Form $record): bool => $record->options->collectResponses ?? false),
                    ])->divided(),

                    ActionGroup::make([
                        DeleteAction::make()
                            ->authorize('delete')
                            ->modalContentView('pages.forms.delete')
                            ->action(function (Form $record): void {
                                DeleteFormManager::run($record);

                                Notification::make()->success()->title($record->name.' form was deleted');
                            }),
                    ])->divided(),
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
                            ->when($ignoredRecords > 0, fn (Notification $notification): Notification => $notification->body(sprintf(
                                '%d %s ignored due to being ineligible for this action.',
                                $ignoredRecords,
                                trans_choice('record was|records were', $ignoredRecords)
                            )))
                            ->send();
                    }),
            ])
            ->filters([
                SelectFilter::make('type')->options(FormType::class),
                SelectFilter::make('status')->options(BasicStatus::class),
            ])
            ->emptyStateIcon(Tabler::List)
            ->emptyStateHeading('No forms found')
            ->emptyStateDescription('Manage all of Nova’s forms.')
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add a form')
                    ->url(route('admin.forms.create')),
            ]);
    }
}
