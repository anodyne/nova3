<?php

declare(strict_types=1);

namespace Nova\Ranks\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Ranks\Actions\CreateRankGroup;
use Nova\Ranks\Data\RankGroupData;
use Nova\Ranks\Enums\RankGroupStatus;
use Nova\Ranks\Models\RankGroup;

class RankGroupsDropdown extends Component
{
    public ?int $groupId = null;

    public ?string $search = null;

    public ?RankGroup $selected = null;

    public ?int $selectedId = null;

    public function createAndSelectGroup(): void
    {
        $group = CreateRankGroup::run(RankGroupData::from([
            'name' => $this->search,
            'status' => RankGroupStatus::active,
        ]));

        $this->selectGroup($group->id);
    }

    public function selectGroup(int $groupId): void
    {
        $this->dispatch('dropdown-close');

        $this->reset('search');

        $this->selectedId = $groupId;
        $this->selected = $this->filteredGroups->where('id', $groupId)->first();
    }

    #[Computed]
    public function filteredGroups(): Collection
    {
        return RankGroup::query()
            ->when($this->search, fn (Builder $query, ?string $value): Builder => $query->searchFor($value))
            ->ordered()
            ->get();
    }

    public function mount(?int $groupId = null): void
    {
        $this->selectedId = $groupId;
        $this->selected = $this->filteredGroups->where('id', $groupId)->first();
    }

    public function render(): View
    {
        return view('pages.ranks.livewire.rank-groups-dropdown', [
            'filteredGroups' => $this->filteredGroups,
        ]);
    }
}
