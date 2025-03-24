<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Gate;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Users\Models\Ban;

class BansList extends TableComponent
{
    public function table(Table $table): Table
    {
        return $table
            ->query(Ban::with(['bannable', 'createdBy']))
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('bannable')
                    ->label('Ban')
                    ->titleColumn()
                    ->getStateUsing(fn (Ban $record): string => $record->bannable?->name ?? $record->ip)
                    ->description(fn (Ban $record): ?string => $record->bannable?->email)
                    ->extraAttributes(['class' => 'tabular-nums']),
                TextColumn::make('created_by.name')->label('Banned by'),
                TextColumn::make('expired_at')
                    ->label('Expiration')
                    ->placeholder('Never')
                    ->date(),
                TextColumn::make('created_at')
                    ->label('Banned on')
                    ->date(),
            ])
            ->actions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make()
                            ->authorize('view')
                            ->slideOver()
                            ->modalWidth(MaxWidth::Large)
                            ->infolist(function (Infolist $infolist): Infolist {
                                return $infolist->schema([
                                    TextEntry::make('bannable.name')
                                        ->label('User name')
                                        ->visible(fn (Ban $record): bool => filled($record->bannable)),
                                    TextEntry::make('ip')
                                        ->label('IP address')
                                        ->extraAttributes(['class' => 'tabular-nums'])
                                        ->visible(fn (Ban $record): bool => filled($record->ip)),
                                    TextEntry::make('created_by.name')->label('Banned by'),
                                    TextEntry::make('created_at')->label('Banned on'),
                                    TextEntry::make('expired_at')
                                        ->label('Expiration')
                                        ->placeholder('No expiration')
                                        ->date(),
                                    TextEntry::make('comment')->label('Comments'),
                                ]);
                            }),
                    ])->authorize('view')->divided(),

                    ActionGroup::make([
                        DeleteAction::make()
                            ->authorize('delete')
                            ->modalContentView('pages.bans.delete')
                            ->successNotificationTitle('Ban was deleted')
                            ->using(fn (Ban $record) => $record->delete()),
                    ])->authorize('delete')->divided(),
                ]),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->authorize('deleteAny')
                    ->modalContentView('pages.bans.delete-bulk')
                    ->action(function (Collection $records): void {
                        $ignoredRecords = 0;

                        $records = $records
                            ->filter(function (Ban $record) use (&$ignoredRecords): bool {
                                if (Gate::allows('delete', $record)) {
                                    return true;
                                }

                                $ignoredRecords += 1;

                                return false;
                            })
                            ->each(fn (Ban $record) => $record->delete());

                        Notification::make()->success()
                            ->title(count($records).' '.trans_choice('ban was|bans were', count($records)).' deleted')
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
                TernaryFilter::make('ip')
                    ->label('Ban type')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->whereNotNull('ip'),
                        false: fn (Builder $query): Builder => $query->whereNull('ip'),
                        blank: fn (Builder $query): Builder => $query,
                    )
                    ->trueLabel('IP bans')
                    ->falseLabel('User bans')
                    ->placeholder('All bans'),
                TernaryFilter::make('hasExpiration')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->whereNotNull('expired_at'),
                        false: fn (Builder $query): Builder => $query->whereNull('expired_at'),
                        blank: fn (Builder $query): Builder => $query,
                    ),
            ])
            ->emptyStateIcon(iconName('forbid'))
            ->emptyStateHeading('No bans found')
            ->emptyStateDescription('')
            ->emptyStateActions([
                CreateAction::make()
                    ->authorize('create')
                    ->label('Add a ban')
                    ->url(route('admin.bans.create')),
            ]);
    }
}
