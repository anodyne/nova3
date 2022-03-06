<?php

declare(strict_types=1);

namespace Nova\Ranks\Livewire;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;
use Nova\Foundation\Livewire\CanReorder;
use Nova\Ranks\Actions\ReorderRankNames;
use Nova\Ranks\Models\RankName;

class RankNamesList extends Component
{
    use AuthorizesRequests;
    use CanReorder;
    use WithPagination;

    public $search;

    public function getFilteredRankNamesProperty()
    {
        $rankNames = RankName::withCount('ranks')
            ->when($this->search, fn ($query, $value) => $query->searchFor($value))
            ->orderBySort();

        if ($this->reordering) {
            return $rankNames->get();
        }

        return $rankNames->paginate();
    }

    public function reorder(array $items): void
    {
        $this->authorize('update', new RankName());

        ReorderRankNames::run($items);
    }

    public function render()
    {
        return view('livewire.ranks.rank-names-list', [
            'rankNames' => $this->filteredRankNames,
        ]);
    }
}
