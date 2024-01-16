<?php

declare(strict_types=1);

namespace Nova\Pages\Livewire;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Nova\Foundation\Filament\Actions\Action;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ReplicateAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Pages\Enums\PageVerb;
use Nova\Pages\Models\Page;
use Nova\Stories\Actions\DeletePostType;
use Nova\Stories\Actions\DuplicatePostType;
use Nova\Stories\Actions\MovePostTypePosts;
use Nova\Stories\Data\PostTypeData;
use Nova\Stories\Events\PostTypeDuplicated;
use Nova\Stories\Models\PostType;

class PagesList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(Page::query())
            ->columns([
                TextColumn::make('uri')
                    ->titleColumn()
                    ->label('Address')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('verb')
                    ->badge()
                    ->label('HTTP Verb')
                    ->color(fn (Page $record): string => $record->verb->color())
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (Model $record): string => $record->trashed() ? 'danger' : $record->status->color())
                    ->formatStateUsing(fn (Model $record): string => $record->trashed() ? 'Deleted' : $record->status->getLabel())
                    ->toggleable(),
            ])
            ->actions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make()
                            ->authorize('view')
                            ->url(fn (Model $record): string => route('pages.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Model $record): string => route('pages.edit', $record)),
                        Action::make('design')
                            ->authorize('design')
                            ->icon(iconName('tools'))
                            ->url(fn (Model $record): string => route('pages.design', $record)),
                    ])->authorizeAny(['view', 'update', 'design'])->divided(),

                    ActionGroup::make([
                        ReplicateAction::make()
                            ->authorize('duplicate')
                            ->modalContentView('pages.pages.duplicate')
                            ->form([
                                TextInput::make('name')->label('Page name'),
                            ])
                            ->action(function (Model $record, array $data): void {
                                $postTypeData = PostTypeData::from([
                                    'name' => $name = data_get($data, 'name'),
                                    'key' => str($name)->slug(),
                                    'fields' => $record->fields,
                                    'options' => $record->options,
                                    'visibility' => $record->visibility,
                                ]);

                                $replica = DuplicatePostType::run($record, $postTypeData);

                                PostTypeDuplicated::dispatch($replica, $record);

                                Notification::make()->success()
                                    ->title("{$replica->name} post type has been created")
                                    ->send();
                            }),
                    ])->authorize('duplicate')->divided(),

                    ActionGroup::make([
                        DeleteAction::make()
                            ->authorize('delete')
                            ->modalContentView('pages.pages.delete')
                            ->form(function (Model $record): ?array {
                                if ($record->posts_count === 0) {
                                    return null;
                                }

                                return [
                                    Select::make('new_post_type')
                                        ->placeholder('Do not move posts to a new post type')
                                        ->options(PostType::where('id', '!=', $record->id)->pluck('name', 'id')),
                                ];
                            })
                            ->action(function (Model $record, array $data): void {
                                if ($newPostTypeId = data_get($data, 'new_post_type')) {
                                    MovePostTypePosts::run(
                                        $record,
                                        $newPostType = PostType::find($newPostTypeId)
                                    );

                                    $record->refresh();
                                }

                                DeletePostType::run($record);

                                Notification::make()->success()
                                    ->title($record->name.' post type was deleted')
                                    ->when(
                                        isset($newPostType),
                                        fn (Notification $notification) => $notification->body('All posts have been re-assigned to the '.$newPostType->name.' post type.')
                                    );
                            }),
                    ])->authorize('delete')->divided(),
                ]),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->authorize('deleteAny')
                    ->modalContentView('pages.post-types.delete-bulk')
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
                            ->each(fn (Model $record): Model => DeletePostType::run($record));

                        Notification::make()->success()
                            ->title(count($records).' '.trans_choice('post type was|post types were', count($records)).' deleted')
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
                SelectFilter::make('verb')
                    ->label('HTTP verb')
                    ->options(PageVerb::class),
            ])
            ->header(fn () => $this->isTableReordering() ? view('filament.tables.reordering-notice') : null)
            ->emptyStateIcon(iconName('list'))
            ->emptyStateHeading('No pages found')
            ->emptyStateDescription('Post types allow you to control the type of content users can create inside of stories.')
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add a page')
                    ->url(route('pages.create')),
            ]);
    }
}
