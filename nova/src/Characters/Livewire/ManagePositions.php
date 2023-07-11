<?php

declare(strict_types=1);

namespace Nova\Characters\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Nova\Characters\Models\Character;
use Nova\Departments\Models\Position;

class ManagePositions extends Component
{
    public string $search = '';

    public ?Character $character = null;

    public Collection $assigned;

    public ?int $primaryPosition = null;

    public function assignPosition(Position $position): void
    {
        $this->search = '';

        $this->assigned->push($position);

        // if ($this->primaryPosition === null) {
        //     $this->primaryPosition = $position->id;
        // }
    }

    public function unassignPosition(Position $position): void
    {
        $this->assigned = $this->assigned->reject(
            fn (Position $collectionPosition) => $collectionPosition->id === $position->id
        );

        // if ($this->primaryPosition === $position->id) {
        //     $this->primaryPosition = match (true) {
        //         $this->assigned->count() === 1 => $this->assigned->first()?->id,
        //         default => null,
        //     };
        // }
    }

    public function setPrimaryPosition(Position $position): void
    {
        $this->primaryPosition = $position->id;
    }

    public function getPositionsProperty(): Collection
    {
        return $this->assigned;
    }

    public function getFilteredPositionsProperty(): Collection
    {
        return Position::query()
            ->unless(auth()->user()->can('create', Character::class), fn (Builder $query) => $query->where('available', '>', 0))
            ->when(filled($this->search) && $this->search !== '*', fn (Builder $query) => $query->searchFor($this->search))
            ->when(filled($this->search) && $this->search === '*', fn (Builder $query) => $query)
            ->get();
    }

    public function getAssignedPositionsProperty(): string
    {
        return $this->assigned
            ->map(fn (Position $position) => $position->id)
            ->join(',');
    }

    public function mount(): void
    {
        $this->assigned = $this->character?->positions ?? Collection::make();

        // $this->primaryPosition = $this->character?->positions()->wherePivot('primary', true)->first()?->id;
    }

    public function render()
    {
        return view('livewire.characters.manage-positions', [
            'assignedPositions' => $this->assignedPositions,
            'filteredPositions' => $this->filteredPositions,
            'positions' => $this->positions,
        ]);
    }
}
