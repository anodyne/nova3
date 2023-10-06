<?php

declare(strict_types=1);

namespace Nova\Ranks\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Nova\Ranks\Actions\CreateRankName;
use Nova\Ranks\Data\RankNameData;
use Nova\Ranks\Enums\RankNameStatus;
use Nova\Ranks\Models\RankName;

class RankNamesDropdown extends Component
{
    public ?int $nameId;

    public ?string $search = null;

    public ?RankName $selected;

    public ?int $selectedId;

    public function createAndSelectName(): void
    {
        $name = CreateRankName::run(RankNameData::from([
            'name' => $this->search,
            'status' => RankNameStatus::active,
        ]));

        $this->selectName($name->id);
    }

    public function selectName(int $nameId)
    {
        $this->dispatch('rank-names-dropdown-close');

        $this->reset('search');

        $this->selectedId = $nameId;
        $this->selected = $this->filteredNames->where('id', $nameId)->first();
    }

    public function getFilteredNamesProperty(): Collection
    {
        return RankName::query()
            ->when($this->search, fn (Builder $query, string $value): Builder => $query->searchFor($value))
            ->ordered()
            ->get();
    }

    public function mount(int $nameId = null): void
    {
        $this->selectedId = $nameId;
        $this->selected = $this->filteredNames->where('id', $nameId)->first();
    }

    public function render(): View
    {
        return view('livewire.ranks.rank-names-dropdown', [
            'filteredNames' => $this->filteredNames,
        ]);
    }
}
