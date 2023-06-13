<?php

declare(strict_types=1);

namespace Nova\Ranks\Livewire;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Livewire\Component;
use Nova\Foundation\Filament\Actions\ActionGroup;
use Nova\Foundation\Filament\Actions\CreateAction;
use Nova\Foundation\Filament\Actions\DeleteAction;
use Nova\Foundation\Filament\Actions\DeleteBulkAction;
use Nova\Foundation\Filament\Actions\EditAction;
use Nova\Foundation\Filament\Actions\ViewAction;
use Nova\Ranks\Actions\DeleteRankItem;
use Nova\Ranks\Enums\RankItemStatus;
use Nova\Ranks\Models\RankItem;

class RankItemsList extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(RankItem::query()->withRankName())
            ->defaultSort('order_column', 'asc')
            ->columns([
                ViewColumn::make('name')
                    ->view('filament.tables.columns.rank')
                    ->searchable(query: fn (Builder $query, string $search) => $query->searchFor($search))
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (Model $record) => $record->status->color())
                    ->toggleable(),
            ])
            ->groups([
                Group::make('group.name')->label('Rank group')->collapsible(),
                Group::make('name.name')->label('Rank name')->collapsible(),
            ])
            ->defaultGroup('group.name')
            ->actions([
                ActionGroup::make([
                    ActionGroup::make([
                        ViewAction::make()
                            ->authorize('view')
                            ->url(fn (Model $record): string => route('ranks.items.show', $record)),
                        EditAction::make()
                            ->authorize('update')
                            ->url(fn (Model $record): string => route('ranks.items.edit', $record)),
                    ])->authorizeAny(['view', 'update'])->divided(),
                    ActionGroup::make([
                        DeleteAction::make()
                            ->modalHeading('Delete rank item?')
                            ->modalSubheading("Are you sure you want to delete this rank? You won't be able to recover it. Any character with this rank will need to have a new rank assigned to them.")
                            ->modalSubmitActionLabel('Delete')
                            ->successNotificationTitle('Rank name was deleted')
                            ->using(fn (Model $record): Model => DeleteRankItem::run($record)),
                    ])->authorize('delete')->divided(),
                ]),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->authorize('deleteAny')
                    ->modalHeading(
                        fn (Collection $records): string => "Delete {$records->count()} selected ".str('rank item')->plural($records->count()).'?'
                    )
                    ->modalSubheading(function (Collection $records): string {
                        $statement = ($records->count() === 1)
                            ? 'this 1 rank item'
                            : "these {$records->count()} rank items";

                        $notice = ($records->count() === 1) ? 'it' : 'them';

                        return "Are you sure you want to delete {$statement}? You won't be able to recover {$notice}. Any characters with those ranks will need to have new ranks assigned to them.";
                    })
                    ->modalSubmitActionLabel('Delete')
                    ->successNotificationTitle('Rank items were deleted')
                    ->using(fn (Collection $records): Collection => $records->each(
                        fn (Model $record): Model => DeleteRankItem::run($record)
                    )),
            ])
            ->filters([
                SelectFilter::make('group_id')
                    ->relationship('group', 'name')
                    ->multiple()
                    ->label('Rank group'),
                SelectFilter::make('name_id')
                    ->relationship('name', 'name')
                    ->multiple()
                    ->label('Rank name'),
                SelectFilter::make('status')->options(RankItemStatus::class),
            ])
            ->reorderable('order_column')
            ->heading('Rank items')
            ->description("Combine the rank group, rank name, and rank images to define your game's ranks")
            ->headerActions([
                CreateAction::make()
                    ->label('Add')
                    ->url(route('ranks.items.create')),
            ])
            ->header(function () use ($table) {
                if ($this->isTableReordering()) {
                    return view('filament.tables.reordering-notice', [
                        'heading' => $table->getHeading(),
                        'description' => $table->getDescription(),
                        'entity' => str('rank items'),
                    ]);
                }
            })
            ->emptyStateIcon(iconName('rank'))
            ->emptyStateHeading('No ranks found')
            ->emptyStateDescription('Rank items bring the rank group, rank name, and images together in a simple and easy-to-use rank experience.')
            ->emptyStateActions([
                CreateAction::make()
                    ->label('Add a rank')
                    ->url(route('ranks.items.create')),
            ]);
    }

    public function render()
    {
        return view('livewire.filament-table');
    }
}
