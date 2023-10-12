<?php

declare(strict_types=1);

namespace Nova\Ranks\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Ranks\Actions\CreateRankName;
use Nova\Ranks\Data\RankNameData;
use Nova\Ranks\Enums\RankNameStatus;
use Nova\Ranks\Models\RankName;

class RankNamesDropdown extends Component
{
    public ?int $nameId = null;

    public string $search = '';

    public ?RankName $selected = null;

    public ?int $selectedId = null;

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

    #[Computed]
    public function filteredNames(): Collection
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
        return view('pages.ranks.livewire.rank-names-dropdown', [
            'filteredNames' => $this->filteredNames,
        ]);
    }
}
