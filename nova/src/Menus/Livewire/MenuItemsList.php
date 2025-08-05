<?php

declare(strict_types=1);

namespace Nova\Menus\Livewire;

use Filament\Support\Enums\IconPosition;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Icons\Icon;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Menus\Actions\DeleteMenuItem;
use Nova\Menus\Enums\LinkTarget;
use Nova\Menus\Enums\LinkType;
use Nova\Menus\Models\MenuItem;
use Nova\Pages\Models\Page;
use RalphJSmit\Filament\Activitylog\Filament\Actions\TimelineAction;
use RalphJSmit\Filament\Activitylog\Filament\Infolists\Components\Timeline;

class MenuItemsList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                MenuItem::query()
                    ->with('page')
                    ->select([
                        'id',
                        'label',
                        'link_type',
                        'order_column',
                        'page_id',
                        'parent_id',
                        'status',
                        'target',
                    ])
                    ->public()
            )
            ->defaultSort('order_column', 'asc')
            ->reorderable('order_column')
            ->columns([
                TextColumn::make('label')
                    ->titleColumn()
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query->searchFor($search))
                    ->sortable(),
                TextColumn::make('link')
                    ->icon(fn (MenuItem $record): ?Icon => $record->target === LinkTarget::Blank ? Icon::External : null)
                    ->iconPosition(IconPosition::After)
                    ->sortable(),
                TextColumn::make('link_type')
                    ->badge()
                    ->toggleable(),
                TextColumn::make('parent.label')
                    ->label('Parent menu item'),
                TextColumn::make('status')
                    ->badge()
                    ->toggleable(),
            ])
            ->recordActions([
                ActionGroup::make([
                    ActionGroup::make([
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (MenuItem $record): string => route('admin.menu-items.edit', $record)),
                    ])->divided(),

                    ActionGroup::make([
                        TimelineAction::make()
                            ->modifyTimelineUsing(function (Timeline $timeline) {
                                $timeline
                                    ->attributeLabels([
                                        'page_id' => 'page',
                                        'parent_id' => 'parent menu item',
                                        'url' => 'URL',
                                    ])
                                    ->attributeValues([
                                        'page_id' => fn (?int $value) => Page::find($value)?->name,
                                        'parent_id' => fn (?int $value) => MenuItem::find($value)?->label,
                                        'target' => fn (?LinkTarget $value) => $value?->getLabel(),
                                    ]);
                            }),
                    ])->divided(),

                    ActionGroup::make([
                        DeleteAction::make()
                            ->authorize('delete')
                            ->modalContentView('pages.menu-items.delete')
                            ->successNotificationTitle(fn (MenuItem $record): string => $record->label.' menu item was deleted')
                            ->using(fn (MenuItem $record): MenuItem => DeleteMenuItem::run($record)),
                    ])->divided(),
                ]),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->authorize('deleteAny')
                    ->modalContentView('pages.menu-items.delete-bulk')
                    ->action(function (Collection $records): void {
                        $ignoredRecords = 0;

                        $records = $records
                            ->filter(function (MenuItem $record) use (&$ignoredRecords): bool {
                                if (Gate::allows('delete', $record)) {
                                    return true;
                                }

                                $ignoredRecords += 1;

                                return false;
                            })
                            ->each(fn (MenuItem $record): MenuItem => DeleteMenuItem::run($record));

                        Notification::make()->success()
                            ->title(count($records).' '.trans_choice('menu item was|menu items were', count($records)).' deleted')
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
                SelectFilter::make('status')->options(BasicStatus::class),
                SelectFilter::make('link_type')->options(LinkType::class),
            ])
            ->header(fn (): ?View => $this->isTableReordering() ? view('filament.tables.reordering-notice') : null)
            ->emptyStateIcon(Icon::Menu)
            ->emptyStateHeading('No menu items found')
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add a menu item')
                    ->url(route('admin.menu-items.create')),
            ]);
    }
}
