<?php

declare(strict_types=1);

namespace Nova\Ranks\Livewire;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;
use Nova\Foundation\Livewire\CanReorder;
use Nova\Ranks\Actions\ReorderRankGroups;
use Nova\Ranks\Models\RankGroup;

class RankGroupsList extends Component
{
    use AuthorizesRequests;
    use CanReorder;
    use WithPagination;

    public $search;

    public function getFilteredRankGroupsProperty()
    {
        $rankGroups = RankGroup::withCount('ranks')
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
            'rankGroups' => $this->filteredRankGroups,
        ]);
    }
}
