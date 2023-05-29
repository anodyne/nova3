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
use Nova\Ranks\Models\RankItem;

class RankItemsList extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(RankItem::query()->withRankName())
            ->columns([
                ViewColumn::make('name')
                    ->view('filament.tables.columns.rank')
                    ->searchable(query: fn (Builder $query, string $search) => $query->searchFor($search)),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (Model $record) => $record->status->color())
                    ->formatStateUsing(fn (Model $record) => $record->status->displayName()),
            ])
            ->groups([
                Group::make('group.name')->label('Rank group')->collapsible(),
                Group::make('name.name')->label('Rank name')->collapsible(),
            ])
            ->defaultGroup('group.name')
            ->defaultSort('order_column', 'asc')
            ->actions([
                ActionGroup::make([
                    ViewAction::make()->url(fn (Model $record) => route('ranks.items.show', $record)),
                    EditAction::make()->url(fn (Model $record) => route('ranks.items.edit', $record)),
                    DeleteAction::make()
                        ->modalHeading('Delete rank item?')
                        ->modalSubheading("Are you sure you want to delete this rank? You won't be able to recover it.")
                        ->modalSubmitActionLabel('Delete')
                        ->using(fn (Model $record) => DeleteRankItem::run($record)),
                ]),
            ])
            ->bulkActions([
                DeleteBulkAction::make()
                    ->action(
                        fn (Collection $records) => $records->each(
                            fn (Model $record) => DeleteRankItem::run($record)
                        )
                    ),
            ])
            ->filters([
                SelectFilter::make('group_id')->relationship('group', 'name')->label('Rank group'),
                SelectFilter::make('name_id')->relationship('name', 'name')->label('Rank name'),
                SelectFilter::make('status')->options(fn () => RankItem::getStatesFor('status')),
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
