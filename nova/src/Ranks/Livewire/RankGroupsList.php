<?php

declare(strict_types=1);

namespace Nova\Ranks\Livewire;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Kirschbaum\LivewireFilters\Filter;
use Kirschbaum\LivewireFilters\HasFilters;
use Livewire\Component;
use Livewire\WithPagination;
use Nova\Foundation\Livewire\Concerns\CanReorder;
use Nova\Ranks\Actions\ReorderRankGroups;
use Nova\Ranks\Models\RankGroup;

class RankGroupsList extends Component
{
    use AuthorizesRequests;
    use CanReorder;
    use HasFilters;
    use WithPagination;

    public $search;

    public function filters(): array
    {
        $statusFilter = Filter::make('status')
            ->options(
                RankGroup::getStatesFor('status')
                    ->flatMap(fn ($status) => [$status => ucfirst($status)])
                    ->all()
            )
            ->default(['active', 'inactive'])
            ->meta(['label' => 'Status']);

        $rankCountFilter = Filter::make('rank_count')
            ->options([
                'none' => 'None',
                'one' => 'One',
                'multiple' => 'More than one',
            ])
            ->meta(['label' => 'Number of ranks']);

        return [
            $statusFilter,
            $rankCountFilter,
        ];
    }

    public function clearAll()
    {
        $this->reset('search');

        $this->emit('livewire-filters-reset');

        $this->dispatchBrowserEvent('close-filters-panel');
    }

    public function getFilteredRankGroupsProperty()
    {
        $rankGroups = RankGroup::withCount('ranks')
            ->when($this->getFilterValue('status'), fn ($query, $values) => $query->whereIn('status', $values))
            ->when($this->getFilterValue('rank_count'), function ($query, $value) {
                return match ($value) {
                    default => $query->has('ranks', '=', 0),
                    'one' => $query->has('ranks', '=', 1),
                    'multiple' => $query->has('ranks', '>=', 2),
                };
            })
            ->when($this->search, fn ($query, $value) => $query->searchFor($value))
            ->orderBySort();

        if ($this->reordering) {
            return $rankGroups->get();
        }

        return $rankGroups->paginate();
    }

    public function reorder(array $items): void
    {
        $this->authorize('update', new RankGroup());

        ReorderRankGroups::run($items);
    }

    public function render()
    {
        return view('livewire.ranks.rank-groups-list', [
            'activeFilterCount' => $this->activeFilterCount,
            'isFiltered' => $this->isFiltered,
            'rankGroupClass' => RankGroup::class,
            'rankGroupCount' => RankGroup::count(),
            'rankGroups' => $this->filteredRankGroups,
        ]);
    }
}
