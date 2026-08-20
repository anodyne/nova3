<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Anodyne\TablerIcons\Tabler;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Gate;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Helpers\DateHelper;
use Nova\Foundation\Icons\Illustration;
use Nova\Foundation\Livewire\TableComponent;
use Nova\Users\Models\Ban;
use Nova\Users\Models\User;

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
                    ->getStateUsing(function (Ban $record): string {
                        $bannable = $record->bannable;

                        if ($bannable instanceof User) {
                            return $bannable->name;
                        }

                        if ($record->getMeta('email')) {
                            return $record->getMeta('email');
                        }

                        return $record->ip;
                    })
                    ->description(function (Ban $record): ?string {
                        $bannable = $record->bannable;

                        if ($bannable instanceof User) {
                            return $bannable->email;
                        }

                        return null;
                    })
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
            ->recordActions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make()
                            ->authorize('view')
                            ->slideOver()
                            ->modalWidth(Width::Large)
                            ->modalIcon(Tabler::Hammer)
                            ->modalHeading('')->modalDescription()
                            ->modalContent(fn (Ban $record, ViewAction $action): Factory|View => view('pages.bans.show', [
                                'record' => $record,
                                'action' => $action,
                            ]))
                            ->schema(fn (Schema $schema): Schema => $schema->components([
                                TextEntry::make('bannable.name')
                                    ->label('User name')
                                    ->visible(fn (Ban $record): bool => filled($record->bannable)),
                                TextEntry::make('ip')
                                    ->label('IP address')
                                    ->extraAttributes(['class' => 'tabular-nums'])
                                    ->visible(fn (Ban $record): bool => filled($record->ip)),
                                TextEntry::make('created_by.name')->label('Banned by'),
                                TextEntry::make('created_at')
                                    ->label('Banned on')
                                    ->formatStateUsing(fn (Ban $record): string => DateHelper::formatDate($record->created_at)),
                                TextEntry::make('expired_at')
                                    ->label('Expiration')
                                    ->placeholder('No expiration')
                                    ->date(),
                                TextEntry::make('comment')->label('Comments'),
                                KeyValueEntry::make('metas')->label('Metadata'),
                            ])),
                    ])->divided(),

                    ActionGroup::make([
                        DeleteAction::make()
                            ->authorize('delete')
                            ->modalContentView('pages.bans.delete')
                            ->successNotificationTitle('Ban was deleted')
                            ->using(fn (Ban $record) => $record->delete()),
                    ])->divided(),
                ]),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->authorize('deleteAny')
                    ->modalContentView('pages.bans.delete-bulk')
                    ->action(function (Collection $records): void {
                        /** @var Collection<int|string, Ban> $banRecords */
                        $banRecords = $records;

                        $ignoredRecords = 0;

                        $records = $banRecords
                            ->filter(function (Ban $record) use (&$ignoredRecords): bool {
                                if (Gate::allows('delete', $record)) {
                                    return true;
                                }

                                $ignoredRecords += 1;

                                return false;
                            })
                            ->each(fn (Ban $record) => $record->delete());

                        Notification::make()->success()
                            ->title(count($banRecords).' '.trans_choice('ban was|bans were', count($banRecords)).' deleted')
                            ->when($ignoredRecords > 0, fn (Notification $notification): Notification => $notification->body(sprintf(
                                '%d %s ignored due to being ineligible for this action.',
                                $ignoredRecords,
                                trans_choice('record was|records were', $ignoredRecords)
                            )))
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
            ->emptyStateIcon(Illustration::SecureMonitor)
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
