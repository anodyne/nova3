<?php

declare(strict_types=1);

namespace Nova\Pages\Livewire;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Set;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Url;
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
use Nova\Pages\Actions\DeletePage;
use Nova\Pages\Actions\DuplicatePage;
use Nova\Pages\Data\PageData;
use Nova\Pages\Enums\PageStatus;
use Nova\Pages\Enums\PageVerb;
use Nova\Pages\Events\PageDuplicated;
use Nova\Pages\Models\Page;

class PagesList extends TableComponent
{
    #[Url]
    public ?array $tableFilters = [
        'pageType',
    ];

    public function table(Table $table): Table
    {
        return $table
            ->query(Page::query())
            ->defaultPaginationPageOption(25)
            ->columns([
                TextColumn::make('name')
                    ->titleColumn()
                    ->label('Page name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('uri')
                    ->label('URL')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('verb')
                    ->badge()
                    ->label('HTTP Verb')
                    ->color(fn (Page $record): string => $record->verb->color())
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('pageType')
                    ->badge()
                    ->state(fn (Page $record): string => $record->is_basic ? 'Basic' : 'Advanced')
                    ->color(fn (string $state): string => match ($state) {
                        'Basic' => 'info',
                        'Advanced' => 'primary',
                    })
                    ->toggleable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (Page $record): string => $record->status->color())
                    ->toggleable(),
            ])
            ->actions([
                ActionGroup::make([
                    ActionGroup::make([
                        Action::make('visit')
                            ->icon(iconName('www'))
                            ->label('Live page')
                            ->url(fn (Page $record): string => url($record->uri))
                            ->visible(fn (Page $record): bool => filled($record->published_blocks)),
                        Action::make('preview')
                            ->icon(iconName('www-preview'))
                            ->label('Preview page')
                            ->url(fn (Page $record): string => route('preview-basic-page', $record->key))
                            ->visible(fn (Page $record): bool => $record->is_previewable),
                    ])->divided(),

                    ActionGroup::make([
                        ViewAction::make()
                            ->authorize('view')
                            ->url(fn (Page $record): string => route('pages.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Page $record): string => route('pages.edit', $record)),
                        Action::make('design')
                            ->authorize('design')
                            ->icon(iconName('tools'))
                            ->url(fn (Page $record): string => route('pages.design', $record)),
                    ])->authorizeAny(['view', 'update', 'design'])->divided(),

                    ActionGroup::make([
                        ReplicateAction::make()
                            ->authorize('duplicate')
                            ->modalContentView('pages.pages.duplicate')
                            ->form([
                                TextInput::make('name')
                                    ->live()
                                    ->debounce(750)
                                    ->afterStateUpdated(fn (Set $set, string $state) => $set('key', str($state)->slug())),
                                TextInput::make('uri')->label('URI'),
                                TextInput::make('key')
                                    ->helperText('The key must be a unique value to identify the page'),
                            ])
                            ->action(function (Page $record, array $data): void {
                                $pageData = PageData::from([
                                    'name' => data_get($data, 'name'),
                                    'key' => data_get($data, 'key'),
                                    'uri' => data_get($data, 'uri'),
                                    'verb' => $record->verb,
                                    'resource' => $record->resource,
                                ]);

                                $replica = DuplicatePage::run($record, $pageData);

                                PageDuplicated::dispatch($replica, $record);

                                Notification::make()->success()
                                    ->title("{$replica->name} page has been created")
                                    ->send();
                            }),
                    ])->authorize('duplicate')->divided(),

                    ActionGroup::make([
                        DeleteAction::make()
                            ->authorize('delete')
                            ->modalContentView('pages.pages.delete')
                            ->action(function (Page $record): void {
                                DeletePage::run($record);

                                Notification::make()->success()
                                    ->title($record->name.' page was deleted')
                                    ->send();
                            }),
                    ])->authorize('delete')->divided(),
                ]),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->authorize('deleteAny')
                    ->modalContentView('pages.pages.delete-bulk')
                    ->action(function (Collection $records): void {
                        $ignoredRecords = 0;

                        $records = $records
                            ->filter(function (Page $record) use (&$ignoredRecords): bool {
                                if (Gate::allows('delete', $record)) {
                                    return true;
                                }

                                $ignoredRecords += 1;

                                return false;
                            })
                            ->each(fn (Page $record): Model => DeletePage::run($record));

                        Notification::make()->success()
                            ->title(count($records).' '.trans_choice('page was|pages were', count($records)).' deleted')
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
                TernaryFilter::make('pageType')
                    ->nullable()
                    ->attribute('resource')
                    ->placeholder('All pages')
                    ->trueLabel('Advanced pages')
                    ->falseLabel('Basic pages'),
                SelectFilter::make('status')->options(PageStatus::class),
                SelectFilter::make('verb')
                    ->label('HTTP verb')
                    ->options(PageVerb::class),
            ])
            ->emptyStateIcon(iconName('list'))
            ->emptyStateHeading('No pages found')
            ->emptyStateDescription('Manage all of Nova’s pages.')
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add a page')
                    ->url(route('pages.create')),
            ]);
    }
}
