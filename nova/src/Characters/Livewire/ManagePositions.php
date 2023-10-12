<?php

declare(strict_types=1);

namespace Nova\Characters\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Position;

class ManagePositions extends Component
{
    public string $search = '';

    public ?Character $character = null;

    public Collection $assigned;

    public function assignPosition(Position $position): void
    {
        $this->search = '';

        $this->assigned->push($position);
    }

    public function unassignPosition(Position $position): void
    {
        $this->assigned = $this->assigned->reject(
            fn (Position $collectionPosition) => $collectionPosition->id === $position->id
        );
    }

    #[Computed]
    public function positions(): Collection
    {
        return $this->assigned;
    }

    #[Computed]
    public function filteredPositions(): Collection
    {
        return Position::query()
            ->unless(auth()->user()->can('create', Character::class), fn (Builder $query) => $query->where('available', '>', 0))
            ->when(filled($this->search) && $this->search !== '*', fn (Builder $query) => $query->searchFor($this->search))
            ->when(filled($this->search) && $this->search === '*', fn (Builder $query) => $query)
            ->get();
    }

    #[Computed]
    public function assignedPositions(): string
    {
        return $this->assigned
            ->map(fn (Position $position) => $position->id)
            ->join(',');
    }

    public function mount(): void
    {
        $this->assigned = $this->character?->positions ?? Collection::make();
    }

    public function render()
    {
        return view('pages.characters.livewire.manage-positions', [
            'assignedPositions' => $this->assignedPositions,
            'filteredPositions' => $this->filteredPositions,
            'positions' => $this->positions,
        ]);
    }
}
