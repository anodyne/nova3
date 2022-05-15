<?php

declare(strict_types=1);

namespace Nova\Ranks\Livewire;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Kirschbaum\LivewireFilters\Filter;
use Kirschbaum\LivewireFilters\HasFilters;
use Livewire\Component;
use Livewire\WithPagination;
use Nova\Foundation\Livewire\CanReorder;
use Nova\Ranks\Actions\ReorderRankItems;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankName;

class RankItemsList extends Component
{
    use AuthorizesRequests;
    use CanReorder;
    use HasFilters;
    use WithPagination;

    public $search;

    public function filters(): array
    {
        $groupsFilter = Filter::make('group')
            ->options(RankGroup::orderBySort()->get()->pluck('name', 'id')->all())
            ->meta(['label' => 'Rank Group']);

        $namesFilter = Filter::make('name')
            ->options(RankName::orderBySort()->get()->pluck('name', 'id')->all())
            ->meta(['label' => 'Rank Name']);

        $statusFilter = Filter::make('status')
            ->options(
                RankItem::getStatesFor('status')
                    ->flatMap(fn ($status) => [$status => ucfirst($status)])
                    ->all()
            )
            ->default(['active', 'inactive'])
            ->meta(['label' => 'Status']);

        return [
            $groupsFilter,
            $namesFilter,
            $statusFilter,
        ];
    }

    public function clearAll()
    {
        $this->reset('search');

        $this->emit('livewire-filters-reset');

        $this->dispatchBrowserEvent('close-filters-panel');
    }

    public function getFilteredRankItemsProperty()
    {
        $rankItems = RankItem::withRankName()
            ->when($this->getFilterValue('group'), fn ($query, $value) => $query->whereGroup($value))
            ->when($this->getFilterValue('name'), fn ($query, $value) => $query->whereName($value))
            ->when($this->getFilterValue('status'), fn ($query, $values) => $query->whereIn('status', $values))
            ->when($this->search, fn ($query, $value) => $query->searchFor($value))
            ->orderBySort();

        if ($this->reordering) {
            return $rankItems->get();
        }

        return $rankItems->paginate();
    }

    public function reorder(array $items): void
    {
        $this->authorize('update', new RankItem());

        ReorderRankItems::run($items);
    }

    public function render()
    {
        return view('livewire.ranks.rank-items-list', [
            'activeFilterCount' => $this->activeFilterCount,
            'isFiltered' => $this->isFiltered,
            'rankItems' => $this->filteredRankItems,
        ]);
    }
}
